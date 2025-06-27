<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Midtrans\Snap;
use Midtrans\Config;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama' => 'required|string',
                'no_meja' => 'required|string',
                'menu_names' => 'required|array',
                'quantities' => 'required|array',
            ]);

            // Konfigurasi Midtrans
            Config::$serverKey = 'SB-Mid-server-qEYmmHXWXktjXZ6iSVQNxmQ5'; // Ganti dengan milikmu
            Config::$isProduction = false;
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // Buat order
            $order = Order::create([
                'nama_pemesan' => $request->nama,
                'no_meja' => $request->no_meja,
                'total' => 0,
                'user_id' => auth()->id(),
            ]);

            $total = 0;
            $items = [];

            foreach ($request->menu_names as $index => $menu_name) {
                $menu = Menu::where('nama', $menu_name)->firstOrFail();
                $qty = (int) $request->quantities[$index];
                $subtotal = $menu->harga * $qty;

                if (!is_null($menu->stok) && $menu->stok >= $qty) {
                    $menu->stok -= $qty;
                    $menu->save();
                } else {
                    return response()->json([
                        'message' => 'Stok untuk "' . $menu->nama . '" tidak mencukupi.'
                    ], 422);
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'nama_menu' => $menu->nama,
                    'qty' => $qty,
                    'subtotal' => $subtotal,
                    'user_id' => auth()->id(),
                ]);

                $total += $subtotal;

                $items[] = [
                    'id' => $menu->id,
                    'price' => $menu->harga,
                    'quantity' => $qty,
                    'name' => $menu->nama,
                ];
            }

            $order->update(['total' => $total]);

            $transactionDetails = [
                'transaction_details' => [
                    'order_id' => 'ORDER-' . $order->id . '-' . time(),
                    'gross_amount' => $total,
                ],
                'item_details' => $items,
                'customer_details' => [
                    'no_meja' => $request->no_meja,
                    'first_name' => $request->nama,
                    'email' => 'user@example.com',
                ],
            ];

            $snapToken = Snap::getSnapToken($transactionDetails);
            $order->update(['snap_token' => $snapToken]);

            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $order->id,
            ]);

        } catch (\Throwable $e) {
            \Log::error('Midtrans Error', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Gagal membuat pesanan.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function history()
    {
        $orders = auth()->user()->orders()->with('items')->latest()->get();
        return view('navigasi.orders', compact('orders'));
    }
}
