<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'no_meja' => 'required|string',
            'menu_names' => 'required|array',
            'quantities' => 'required|array',
        ]);

        $order = Order::create([
            'nama_pemesan' => $request->nama,
            'no_meja' => $request->no_meja,
            'total' => 0,
            'user_id' => auth()->id(),
        ]);

        $total = 0;

        foreach ($request->menu_names as $index => $menu_name) {
            $menu = Menu::where('nama', $menu_name)->firstOrFail();
            $qty = (int) $request->quantities[$index];
            $subtotal = $menu->harga * $qty;

            // Kurangi stok jika mencukupi
            if (!is_null($menu->stok) && $menu->stok >= $qty) {
                $menu->stok -= $qty;
                $menu->save();
            } else {
                return redirect()->back()->withErrors(['Stok untuk "' . $menu->nama . '" tidak mencukupi.']);
            }

            OrderItem::create([
                'order_id' => $order->id,
                'nama_menu' => $menu->nama,
                'qty' => $qty,
                'subtotal' => $subtotal,
                'user_id' => auth()->id(),
            ]);

            $total += $subtotal;
        }

        $order->update(['total' => $total]);

        return redirect('/menu')->with('success', 'Pesanan berhasil disimpan!');
    }

    public function history()
    {
        $orders = auth()->user()->orders()->with('items')->latest()->get();
        return view('navigasi.orders', compact('orders'));
    }
}
