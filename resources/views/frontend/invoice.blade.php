<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $order->order_id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; color: #1a1a1a; line-height: 1.5; }
        .invoice-container { max-width: 700px; margin: 0 auto; padding: 40px 30px; }

        /* Header */
        .invoice-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 2px solid #536451; }
        .brand-name { font-size: 28px; font-weight: 900; letter-spacing: 2px; color: #536451; }
        .brand-sub { font-size: 10px; color: #999; letter-spacing: 1px; margin-top: 2px; }
        .invoice-title { text-align: right; }
        .invoice-title h1 { font-size: 22px; font-weight: 700; color: #536451; letter-spacing: 1px; text-transform: uppercase; }
        .invoice-title p { font-size: 12px; color: #666; margin-top: 4px; }

        /* Info Sections */
        .info-grid { display: flex; justify-content: space-between; margin-bottom: 30px; gap: 20px; }
        .info-block { flex: 1; }
        .info-block h3 { font-size: 10px; text-transform: uppercase; letter-spacing: 1.5px; color: #536451; margin-bottom: 8px; font-weight: 700; }
        .info-block p { font-size: 13px; color: #333; margin-bottom: 2px; }
        .info-block .value { font-weight: 600; color: #1a1a1a; }

        /* Table */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 30px; }
        thead th { background-color: #536451; color: #f3e9d5; padding: 10px 12px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; }
        tbody td { border-bottom: 1px solid #eee; padding: 12px; font-size: 13px; }
        tbody tr:last-child td { border-bottom: none; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* Totals */
        .totals { width: 280px; margin-left: auto; margin-bottom: 40px; }
        .totals-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 13px; color: #555; }
        .totals-row.grand { border-top: 2px solid #536451; padding-top: 12px; margin-top: 8px; font-size: 16px; font-weight: 700; color: #1a1a1a; }

        /* Footer */
        .invoice-footer { text-align: center; padding-top: 30px; border-top: 1px solid #eee; }
        .invoice-footer p { font-size: 12px; color: #999; }
        .invoice-footer .brand { font-weight: 700; color: #536451; }
    </style>
</head>

<body>
    <div class="invoice-container">
        {{-- Header --}}
        <div class="invoice-header">
            <div>
                <div class="brand-name">GET READY</div>
                <div class="brand-sub">PREMIUM MENSWEAR — EST. 2004</div>
            </div>
            <div class="invoice-title">
                <h1>Invoice</h1>
                <p>{{ $order->created_at->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }}</p>
            </div>
        </div>

        {{-- Order & Customer Info --}}
        <div class="info-grid">
            <div class="info-block">
                <h3>Order Details</h3>
                <p><strong>Order ID:</strong> <span class="value">{{ $order->order_id }}</span></p>
                <p><strong>Date:</strong> {{ $order->created_at->setTimezone('Asia/Kolkata')->format('d M Y') }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            </div>
            <div class="info-block">
                <h3>Billing / Shipping</h3>
                <p class="value">{{ $order->name }}</p>
                <p>{{ $order->address }}</p>
                <p>{{ $order->city }}, {{ $order->state }} — {{ $order->zip }}</p>
                <p>Phone: {{ $order->phone }}</p>
                <p>Email: {{ $order->email }}</p>
            </div>
        </div>

        {{-- Items Table --}}
        <table>
            <thead>
                <tr>
                    <th style="width: 40%;">Product</th>
                    <th class="text-center">Size</th>
                    <th class="text-center">Qty</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td class="text-center">{{ $item->size }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">₹{{ number_format($item->price, 2) }}</td>
                    <td class="text-right" style="font-weight:600;">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        @php
            $shipping = $order->shipping_fee ?? 0.00;
            $discount = $order->discount_amount ?? 0.00;
            $subtotal = $order->total_amount - $shipping + $discount;
        @endphp
        <div class="totals">
            <div class="totals-row">
                <span>Subtotal</span>
                <span>₹{{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="totals-row">
                <span>Shipping</span>
                <span>{{ $shipping > 0 ? '₹' . number_format($shipping, 2) : 'Free' }}</span>
            </div>
            @if($discount > 0)
            <div class="totals-row" style="color: #c2410c;">
                <span>Discount ({{ $order->coupon_code }})</span>
                <span>-₹{{ number_format($discount, 2) }}</span>
            </div>
            @endif
            <div class="totals-row grand">
                <span>Total</span>
                <span>₹{{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>

        {{-- Footer --}}
        <div class="invoice-footer">
            <p><span class="brand">GET READY</span> — Premium Menswear EST. 2004</p>
            <p style="margin-top: 6px;">Thank you for shopping with us!</p>
            <p style="margin-top: 12px; font-size: 10px; color: #bbb;">This is a computer-generated invoice and does not require a signature.</p>
        </div>
    </div>
</body>

</html>