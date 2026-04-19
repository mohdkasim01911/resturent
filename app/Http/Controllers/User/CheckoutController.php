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
        
        // Calculate total
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $deliveryFee = 50;
        $gst = $subtotal * 0.05;
        $totalAmount = $subtotal + $deliveryFee + $gst;
        
        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => 'razorpay',
            'shipping_address' => $request->address,
            'phone' => $request->phone
        ]);
        
        // Create order items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'food_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'portion_name' => $item['variant_name'] ?? null
            ]);
        }
        
        // Store order ID in session
        Session::put('current_order_id', $order->id);
        
        // Redirect to payment
        return redirect()->route('user.payment.index', ['order_id' => $order->id]);
    }
}