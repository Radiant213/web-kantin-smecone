<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kantin;
use App\Models\Kiosk;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $totalOrders = Order::count();
        $activeKiosks = Kiosk::count();
        $totalUsers = User::where('role', 'pembeli')->count();

        $recentOrders = Order::with(['user', 'kiosk'])
            ->latest()
            ->take(10)
            ->get();

        $kantins = Kantin::withCount('kiosks')->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'activeKiosks',
            'totalUsers',
            'recentOrders',
            'kantins'
        ));
    }
}
