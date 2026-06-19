<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation | GET READY</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f3e9d5; padding: 20px; color: #1a1a1a; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 40px; border-radius: 4px; border: 1px solid #d3cdbf; }
        .header { text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #d3cdbf; }
        .logo { font-size: 24px; font-weight: 900; letter-spacing: 2px; color: #536451; margin: 0; }
        .title { font-size: 18px; font-weight: bold; margin-top: 10px; text-transform: uppercase; letter-spacing: 1px; color: #1a1a1a; }
        .details-section { margin-bottom: 30px; }
        .details-title { font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color: #536451; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { text-align: left; padding: 10px; font-size: 12px; text-transform: uppercase; color: #555; background-color: #f9f9f9; border-bottom: 1px solid #ddd; }
        td { padding: 10px; font-size: 14px; border-bottom: 1px solid #eee; }
        .totals { margin-top: 20px; text-align: right; font-size: 14px; }
        .total-row { display: flex; justify-content: flex-end; padding: 5px 0; }
        .total-row span { width: 100px; }
        .total-row strong { font-size: 16px; color: #536451; }
        .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #777; padding-top: 20px; border-top: 1px solid #d3cdbf; }
        .btn { display: inline-block; background-color: #536451; color: #f3e9d5; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-weight: bold; letter-spacing: 0.5px; margin-top: 20px; font-size: 12px; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="logo">GET READY.</h1>
            <div class="title">Transmission Received</div>
        </div>
        
        <p>Hello {{ $order->name }},</p>
        <p>Your order has been successfully logged into our dispatch system. We are currently processing it at HQ.</p>
        
        <div class="details-section">
            <div class="details-title">Order Logistics</div>
            <p style="margin: 0; font-size: 14px;"><strong>Order ID:</strong> {{ $order->order_id }}</p>
            <p style="margin: 0; font-size: 14px;"><strong>Placed On:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
            <p style="margin: 0; font-size: 14px;"><strong>Status:</strong> <span style="text-transform: uppercase; font-weight: bold;">{{ $order->status }}</span></p>
        </div>
        
        <div class="details-section">
            <div class="details-title">Shipping Coordinates</div>
            <p style="margin: 0; font-size: 14px;">{{ $order->address }}<br>
            {{ $order->city }}, {{ $order->state }} {{ $order->zip }}</p>
        </div>
        
        <div class="details-section">
            <div class="details-title">Manifest</div>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Size</th>
                        <th>Qty</th>
                        <th style="text-align: right;">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->size }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td style="text-align: right;">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="totals">
                <div class="total-row"><span>Subtotal:</span> <span>₹{{ number_format($order->total_amount, 2) }}</span></div>
                <div class="total-row"><span>Shipping:</span> <span>Free</span></div>
                <div class="total-row"><span><strong>Total:</strong></span> <strong>₹{{ number_format($order->total_amount, 2) }}</strong></div>
            </div>
        </div>
        
        <div style="text-align: center;">
            <a href="{{ route('orders.show', $order->order_id) }}" class="btn">View Order Status</a>
        </div>
        
        <div class="footer">
            <p>Thank you for choosing GET READY.<br>Heavy fabrics. Honest stitching. Pieces that earn their fade.</p>
            <p>If you have any questions, reply to this email or contact <a href="mailto:support@getready.com" style="color: #536451;">support@getready.com</a>.</p>
        </div>
    </div>
</body>
</html>
