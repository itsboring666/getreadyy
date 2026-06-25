<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed — {{ $order->order_id }} | GET READY</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f0ece3;
            padding: 32px 16px;
            color: #1a1a1a;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        .email-wrap {
            max-width: 620px;
            margin: 0 auto;
        }

        /* ── Header ── */
        .email-header {
            background: #1a1a1a;
            text-align: center;
            padding: 32px 40px;
            border-bottom: 3px solid #536451;
        }
        .email-header .brand {
            font-size: 28px;
            font-weight: 900;
            letter-spacing: 4px;
            color: #f0ece3;
            text-transform: uppercase;
        }
        .email-header .subtitle {
            font-size: 11px;
            color: #888;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 6px;
        }

        /* ── Body ── */
        .email-body {
            background: #fff;
            padding: 40px;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
        }

        .confirm-banner {
            background: #536451;
            color: #f0ece3;
            text-align: center;
            padding: 20px;
            margin-bottom: 32px;
        }
        .confirm-banner .icon { font-size: 28px; margin-bottom: 6px; }
        .confirm-banner .confirm-title {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .confirm-banner .confirm-sub {
            font-size: 11px;
            color: #c5d4c1;
            margin-top: 4px;
        }

        .greeting { font-size: 14px; color: #333; margin-bottom: 12px; }
        .greeting strong { color: #1a1a1a; }
        .intro-text { font-size: 13px; color: #555; margin-bottom: 28px; line-height: 1.7; }

        /* ── Section headers ── */
        .section-title {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #536451;
            border-bottom: 1px solid #e5e5e5;
            padding-bottom: 8px;
            margin-bottom: 16px;
        }

        /* ── Order Meta ── */
        .order-meta {
            background: #fafaf8;
            border: 1px solid #e8e4db;
            padding: 20px;
            margin-bottom: 28px;
        }
        .meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            border-bottom: 1px solid #f0ece3;
            font-size: 13px;
        }
        .meta-row:last-child { border-bottom: none; }
        .meta-key { color: #777; }
        .meta-val { font-weight: 600; color: #1a1a1a; }
        .status-pill {
            display: inline-block;
            background: #536451;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 3px 10px;
        }

        /* ── Items Table ── */
        .items-section { margin-bottom: 28px; }
        .items-table { width: 100%; border-collapse: collapse; }
        .items-table th {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #888;
            padding: 8px 10px;
            border-top: 1px solid #1a1a1a;
            border-bottom: 1px solid #1a1a1a;
            text-align: left;
            background: #fff;
        }
        .items-table td {
            font-size: 12px;
            padding: 11px 10px;
            border-bottom: 1px solid #f0f0f0;
            color: #333;
            vertical-align: top;
        }
        .items-table tbody tr:last-child td { border-bottom: none; }
        .item-name-cell { font-weight: 600; color: #1a1a1a; }
        .item-size-pill {
            display: inline-block;
            background: #f0ece3;
            color: #536451;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 2px 6px;
            margin-top: 3px;
        }

        /* ── Totals ── */
        .totals-section { margin-bottom: 28px; }
        .totals-box { border: 1px solid #e5e5e5; }
        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 16px;
            font-size: 12px;
            border-bottom: 1px solid #f5f5f5;
        }
        .total-row:last-child { border-bottom: none; }
        .total-row .t-label { color: #666; }
        .total-row .t-val { font-weight: 600; color: #1a1a1a; }
        .total-row.discount { background: #fffbf5; }
        .total-row.discount .t-label, .total-row.discount .t-val { color: #b45309; }
        .total-row.grand { background: #1a1a1a; border-bottom: none; }
        .total-row.grand .t-label { color: #ccc; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; }
        .total-row.grand .t-val { color: #fff; font-size: 18px; font-weight: 800; }

        /* ── Shipping Box ── */
        .shipping-section { margin-bottom: 28px; }
        .shipping-box { background: #fafaf8; border: 1px solid #e8e4db; padding: 20px; }
        .shipping-name { font-size: 14px; font-weight: 700; color: #1a1a1a; margin-bottom: 4px; }
        .shipping-addr { font-size: 12px; color: #555; line-height: 1.7; }
        .shipping-phone { font-size: 12px; color: #555; margin-top: 8px; }

        /* ── CTA Button ── */
        .cta-wrap { text-align: center; margin: 32px 0 24px; }
        .cta-btn {
            display: inline-block;
            background: #536451;
            color: #f0ece3;
            padding: 14px 32px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .cta-btn:hover { background: #3e4d3c; }

        /* ── Note ── */
        .note-box {
            background: #fffbf0;
            border-left: 3px solid #d97706;
            padding: 14px 16px;
            margin-bottom: 28px;
            font-size: 12px;
            color: #555;
        }
        .note-box strong { color: #92400e; }

        /* ── Footer ── */
        .email-footer {
            background: #1a1a1a;
            text-align: center;
            padding: 24px 40px;
            border-top: 3px solid #536451;
        }
        .footer-brand { font-size: 16px; font-weight: 900; letter-spacing: 3px; color: #f0ece3; margin-bottom: 6px; }
        .footer-tagline { font-size: 10px; color: #666; letter-spacing: 1px; margin-bottom: 12px; }
        .footer-contact { font-size: 11px; color: #555; line-height: 1.8; }
        .footer-contact a { color: #8aa888; text-decoration: none; }
        .footer-legal { font-size: 9px; color: #444; margin-top: 12px; letter-spacing: 0.5px; }
    </style>
</head>
<body>
<div class="email-wrap">

    {{-- ── HEADER ── --}}
    <div class="email-header">
        <div class="brand">GET READY.</div>
        <div class="subtitle">Streetwear. Authentic. Uncompromised.</div>
    </div>

    {{-- ── BODY ── --}}
    <div class="email-body">

        {{-- Confirmation Banner --}}
        <div class="confirm-banner">
            <div class="icon">✓</div>
            <div class="confirm-title">Order Confirmed</div>
            <div class="confirm-sub">Your order has been received and is being processed.</div>
        </div>

        <p class="greeting">Hello, <strong>{{ $order->name }}</strong></p>
        <p class="intro-text">
            Thank you for your purchase! We've successfully received your order and our team is processing it at headquarters.
            You'll receive another email once your order has been shipped.
        </p>

        {{-- Order Meta --}}
        <div class="section-title">Order Details</div>
        <div class="order-meta">
            <div class="meta-row">
                <span class="meta-key">Order ID</span>
                <span class="meta-val">{{ $order->order_id }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-key">Placed On</span>
                <span class="meta-val">{{ $order->created_at->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-key">Status</span>
                <span class="meta-val"><span class="status-pill">{{ strtoupper($order->status) }}</span></span>
            </div>
            <div class="meta-row">
                <span class="meta-key">Total Items</span>
                <span class="meta-val">{{ $order->items->count() }} item(s)</span>
            </div>
        </div>

        {{-- Items --}}
        <div class="items-section">
            <div class="section-title">Items Ordered</div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th style="text-align:center;">Qty</th>
                        <th style="text-align:right;">Price</th>
                        <th style="text-align:right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div class="item-name-cell">{{ $item->product_name }}</div>
                            <div><span class="item-size-pill">{{ $item->size }}</span></div>
                        </td>
                        <td style="text-align:center;">{{ $item->quantity }}</td>
                        <td style="text-align:right;">₹{{ number_format($item->price, 2) }}</td>
                        <td style="text-align:right; font-weight:600;">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Totals --}}
        @php
            $shipping = $order->shipping_fee ?? 0;
            $discount = $order->discount_amount ?? 0;
            $subtotal = $order->total_amount - $shipping + $discount;
        @endphp
        <div class="totals-section">
            <div class="totals-box">
                <div class="total-row">
                    <span class="t-label">Subtotal</span>
                    <span class="t-val">₹{{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="total-row">
                    <span class="t-label">Shipping</span>
                    <span class="t-val">{{ $shipping > 0 ? '₹' . number_format($shipping, 2) : 'FREE' }}</span>
                </div>
                @if($discount > 0)
                <div class="total-row discount">
                    <span class="t-label">Discount{{ $order->coupon_code ? ' (' . $order->coupon_code . ')' : '' }}</span>
                    <span class="t-val">— ₹{{ number_format($discount, 2) }}</span>
                </div>
                @endif
                <div class="total-row grand">
                    <span class="t-label">Total Paid</span>
                    <span class="t-val">₹{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Shipping Address --}}
        <div class="shipping-section">
            <div class="section-title">Shipping Address</div>
            <div class="shipping-box">
                <div class="shipping-name">{{ $order->name }}</div>
                <div class="shipping-addr">
                    {{ $order->address }}<br>
                    {{ $order->city }}, {{ $order->state }} — {{ $order->zip }}
                </div>
                <div class="shipping-phone">📞 {{ $order->phone }}</div>
            </div>
        </div>

        {{-- Note --}}
        <div class="note-box">
            <strong>What's next?</strong> Our team will process your order within 1–2 business days.
            Once shipped, you'll receive a tracking number via email so you can follow your package in real time.
        </div>

        {{-- CTA --}}
        <div class="cta-wrap">
            <a href="{{ route('orders.show', $order->order_id) }}" class="cta-btn">View Order Status</a>
        </div>

    </div>

    {{-- ── FOOTER ── --}}
    <div class="email-footer">
        <div class="footer-brand">GET READY.</div>
        <div class="footer-tagline">Heavy fabrics. Honest stitching. Pieces that earn their fade.</div>
        <div class="footer-contact">
            Questions? Reach us on
            <a href="https://wa.me/919080253885">WhatsApp: +91 9080253885</a><br>
            or follow us on Instagram:
            <a href="https://www.instagram.com/_getreadyyyy">@_getreadyyyy</a>
        </div>
        <div class="footer-legal">
            This email was sent to {{ $order->email }} regarding your order {{ $order->order_id }}.<br>
            © {{ date('Y') }} GET READY. All rights reserved.
        </div>
    </div>

</div>
</body>
</html>
