<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_revenue'  => Order::where('status', '!=', 'cancelled')->sum('total'),
            'total_orders'   => Order::count(),
            'total_products' => Product::count(),
            'total_users'    => User::where('role', 'customer')->count(),
        ];

        $recentOrders = Order::with(['user', 'items'])->latest()->take(10)->get();
        $lowStock = Product::where('stock_qty', '<', 10)->where('is_active', true)->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'lowStock'));
    }
}
