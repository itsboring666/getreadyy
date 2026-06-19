<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your Order Has Shipped | GET READY</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f3e9d5; padding: 20px; color: #1a1a1a; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 40px; border-radius: 4px; border: 1px solid #d3cdbf; }
        .header { text-align: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #d3cdbf; }
        .logo { font-size: 24px; font-weight: 900; letter-spacing: 2px; color: #536451; margin: 0; }
        .title { font-size: 18px; font-weight: bold; margin-top: 10px; text-transform: uppercase; letter-spacing: 1px; color: #1a1a1a; }
        .details-section { margin-bottom: 30px; background-color: #f9f9f9; padding: 20px; border: 1px solid #eee; border-radius: 4px; }
        .details-title { font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color: #536451; margin-bottom: 10px; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #777; padding-top: 20px; border-top: 1px solid #d3cdbf; }
        .btn { display: inline-block; background-color: #536451; color: #f3e9d5; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-weight: bold; letter-spacing: 0.5px; margin-top: 20px; font-size: 12px; text-transform: uppercase; }
        .tracking-number { font-family: monospace; font-size: 18px; font-weight: bold; color: #1a1a1a; margin: 10px 0; background: #e9e9e9; padding: 10px; text-align: center; letter-spacing: 2px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="logo">GET READY.</h1>
            <div class="title">Package Dispatched</div>
        </div>
        
        <p>Hello {{ $order->name }},</p>
        <p>Great news! Your order <strong>#{{ $order->order_id }}</strong> has left our facility and is now in transit to your location.</p>
        
        <div class="details-section">
            <div class="details-title">Tracking Intelligence</div>
            @if($order->tracking_number)
                <p style="margin-top: 0; font-size: 14px;">Your tracking number is:</p>
                <div class="tracking-number">{{ $order->tracking_number }}</div>
            @else
                <p style="margin: 0; font-size: 14px;">Your package has been dispatched via standard courier. Tracking details will be updated shortly.</p>
            @endif
        </div>
        
        <div class="details-section" style="background-color: transparent; padding: 0; border: none;">
            <div class="details-title">Shipping Coordinates</div>
            <p style="margin: 0; font-size: 14px;">{{ $order->address }}<br>
            {{ $order->city }}, {{ $order->state }} {{ $order->zip }}</p>
        </div>
        
        <div style="text-align: center;">
            <a href="{{ route('orders.show', $order->order_id) }}" class="btn">Track Order Online</a>
        </div>
        
        <div class="footer">
            <p>Thank you for choosing GET READY.<br>Heavy fabrics. Honest stitching. Pieces that earn their fade.</p>
            <p>If you have any questions, reply to this email or contact <a href="mailto:support@getready.com" style="color: #536451;">support@getready.com</a>.</p>
        </div>
    </div>
</body>
</html>
