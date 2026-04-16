<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; }
        .header { text-align: center; margin-bottom: 30px; }
        .order-info { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        .total { margin-top: 20px; text-align: right; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <h1>FoodieHub Invoice</h1>
            <p>Order #{{ $order->id }}</p>
        </div>
        
        <div class="order-info">
            <p><strong>Customer:</strong> {{ $order->user->name }}</p>
            <p><strong>Email:</strong> {{ $order->user->email }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->food->name }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="total">
            <p><strong>Total: ${{ number_format($order->total_amount, 2) }}</strong></p>
        </div>
    </div>
</body>
</html>