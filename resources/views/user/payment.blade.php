@extends('layouts.user')

@section('title', 'Payment')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-orange-500 to-red-600 px-6 py-4">
            <h1 class="text-2xl font-bold text-white">Complete Payment</h1>
            <p class="text-white/80">Order #{{ $order->id }}</p>
        </div>
        
        <div class="p-6">
            <div class="text-center mb-8">
                <div class="text-6xl mb-4">💳</div>
                <h3 class="text-xl font-semibold mb-2">Total Amount: ₹{{ number_format($amount, 2) }}</h3>
                <p class="text-gray-500">Pay securely using Razorpay</p>
            </div>
            
            <div class="text-center">
                <button id="payBtn" class="bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-700 transition">
                    Pay ₹{{ number_format($amount, 2) }}
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    document.getElementById('payBtn').addEventListener('click', function(e) {
        var options = {
            key: "{{ $razorpayKey }}",
            amount: {{ $amount * 100 }},
            currency: "INR",
            name: "FoodieHub",
            description: "Order #{{ $order->id }}",
            order_id: "{{ $razorpayOrderId }}",
            handler: function(response) {
                // Submit to success route
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = "{{ route('user.payment.success') }}";
                
                form.innerHTML = `
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="razorpay_order_id" value="${response.razorpay_order_id}">
                    <input type="hidden" name="razorpay_payment_id" value="${response.razorpay_payment_id}">
                    <input type="hidden" name="razorpay_signature" value="${response.razorpay_signature}">
                `;
                
                document.body.appendChild(form);
                form.submit();
            },
            prefill: {
                name: "{{ Auth::user()->name }}",
                email: "{{ Auth::user()->email }}",
                contact: "{{ $order->phone }}"
            },
            theme: {
                color: "#F97316"
            },
            modal: {
                ondismiss: function() {
                    window.location.href = "{{ route('user.payment.failed') }}";
                }
            }
        };
        
        var rzp = new Razorpay(options);
        rzp.open();
        e.preventDefault();
    });
</script>
@endsection