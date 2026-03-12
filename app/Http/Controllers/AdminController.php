<?php

namespace App\Http\Controllers;

use App\Models\CreditApplication;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers     = User::where('role', 'customer')->count();
        $verifiedUsers  = User::where('kyc_status', 'verified')->count();
        $totalOrders    = Order::count();
        $pendingOrders  = Order::where('status', 'pending')->count();
        $totalRevenue   = Order::where('status', 'delivered')->sum('grand_total');
        $totalCredits   = CreditApplication::count();
        $pendingCredits = CreditApplication::where('status', 'pending')->count();

        $recentOrders  = Order::with('user')->latest('ordered_at')->limit(6)->get();
        $recentCredits = CreditApplication::with('user')->where('status', 'pending')->latest()->limit(6)->get();
        $lowStockProducts = Product::with('category')->where('stock', '<=', 3)->where('is_active', true)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'verifiedUsers',
            'totalOrders',
            'pendingOrders',
            'totalRevenue',
            'totalCredits',
            'pendingCredits',
            'recentOrders',
            'recentCredits',
            'lowStockProducts'
        ));
    }
}
