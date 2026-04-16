<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty!');
        }
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        $user = Auth::user();
        
        return view('user.checkout', compact('cart', 'total', 'user'));
    }
    
    public function process(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'address' => 'required|string',
        ]);
        
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('user.cart')->with('error', 'Your cart is empty!');
        }
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => $request->address,
            'phone' => $request->phone,
        ]);
        
        // Create order items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'food_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
        
        // Clear cart
        Session::forget('cart');
        
        return redirect()->route('user.order.show', $order->id)->with('success', 'Order placed successfully!');
    }
    
    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        
        return view('user.orders', compact('orders'));
    }
}