<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Menu;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung total penghasilan dari semua pesanan
        $totalIncome = Order::sum('total');

        // Ambil semua pesanan terbaru
        $orders = Order::latest()->get();

        // Ambil menu dengan stok kurang dari 5
        $lowStockMenus = Menu::where('stok', '<', 5)->get();

        // Kirim semua data ke view
        return view('admin.dashboard', compact('totalIncome', 'orders', 'lowStockMenus'));
    }
}
