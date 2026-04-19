<?php

namespace App\Services;

use Razorpay\Api\Api;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class RazorpayService
{
    protected $api;
    
    public function __construct()
    {
        $this->api = new Api(config('razorpay.key'), config('razorpay.secret'));
    }
    
    public function createOrder(Order $order)
    {
        try {
            $razorpayOrder = $this->api->order->create([
                'receipt' => 'order_' . $order->id,
                'amount' => $order->total_amount * 100,
                'currency' => config('razorpay.currency'),
                'payment_capture' => 1
            ]);
            
            Payment::create([
                'order_id' => $order->id,
                'razorpay_order_id' => $razorpayOrder->id,
                'amount' => $order->total_amount,
                'currency' => config('razorpay.currency'),
                'status' => 'pending'
            ]);
            
            return [
                'success' => true,
                'order_id' => $razorpayOrder->id,
                'amount' => $order->total_amount,
                'key' => config('razorpay.key')
            ];
            
        } catch (\Exception $e) {
            Log::error('Razorpay Order Failed: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    public function verifyPayment($orderId, $paymentId, $signature)
    {
        try {
            $attributes = [
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature
            ];
            
            $this->api->utility->verifyPaymentSignature($attributes);
            return ['success' => true];
            
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}