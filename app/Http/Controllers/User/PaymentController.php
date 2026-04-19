<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    // Show payment page
    public function index(Request $request)
    {
        $orderId = $request->order_id;
        $order = Order::findOrFail($orderId);
        
        $razorpay = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        
        $razorpayOrder = $razorpay->order->create([
            'receipt' => 'order_' . $order->id,
            'amount' => $order->total_amount * 100,
            'currency' => 'INR',
            'payment_capture' => 1
        ]);
        
        return view('user.payment', [
            'order' => $order,
            'razorpayOrderId' => $razorpayOrder->id,
            'razorpayKey' => env('RAZORPAY_KEY'),
            'amount' => $order->total_amount
        ]);
    }
    
    // Handle payment success (from frontend)
    public function success(Request $request)
    {
        $orderId = Session::get('current_order_id');
        
        if (!$orderId) {
            return redirect()->route('user.cart')->with('error', 'Invalid order');
        }
        
        $order = Order::findOrFail($orderId);
        
        try {
            $razorpay = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            
            // Verify payment signature
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];
            
            $razorpay->utility->verifyPaymentSignature($attributes);
            
            // Update order
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
                'transaction_id' => $request->razorpay_payment_id
            ]);
            
            // Clear cart
            Session::forget('cart');
            Session::forget('current_order_id');
            
            return redirect()->route('user.order.show', $order->id)
                ->with('success', 'Payment successful! Order placed.');
                
        } catch (\Exception $e) {
            $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
            
            return redirect()->route('user.cart')
                ->with('error', 'Payment verification failed. Please try again.');
        }
    }
    
    // Handle payment failure
    public function failed(Request $request)
    {
        $orderId = Session::get('current_order_id');
        
        if ($orderId) {
            $order = Order::find($orderId);
            if ($order) {
                $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
            }
        }
        
        Session::forget('current_order_id');
        
        return redirect()->route('user.cart')
            ->with('error', 'Payment failed. Please try again.');
    }
}