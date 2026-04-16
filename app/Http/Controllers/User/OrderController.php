<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.food')
            ->latest()
            ->paginate(10);
        
        return view('user.orders', compact('orders'));
    }
    
    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with('items.food')
            ->findOrFail($id);
        
        return view('user.order-detail', compact('order'));
    }
    
    public function cancel($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'processing'])
            ->findOrFail($id);
        
        $order->update(['status' => 'cancelled']);
        
        return redirect()->back()->with('success', 'Order cancelled successfully!');
    }
}