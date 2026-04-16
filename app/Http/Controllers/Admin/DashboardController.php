<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Food;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic Stats
        $totalOrders = Order::count();
        $totalUsers = User::where('role', 'user')->count();
        $totalFoods = Food::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        
        // Revenue Stats
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        
        // Order Status Distribution
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $cancelledOrders = Order::where('status', 'cancelled')->count();
        
        // Recent Orders
        $recentOrders = Order::with('user')->latest()->take(5)->get();
        
        // Pass all data to view
        return view('admin.dashboard', compact(
            'totalOrders',
            'totalUsers', 
            'totalFoods',
            'pendingOrders',
            'totalRevenue',
            'processingOrders',
            'completedOrders', 
            'cancelledOrders',
            'recentOrders'
        ));
    }
}