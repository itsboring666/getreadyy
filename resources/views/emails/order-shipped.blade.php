<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Order Has Shipped — {{ $order->order_id }} | GET READY</title>
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
        .email-wrap { max-width: 620px; margin: 0 auto; }

        /* ── Header ── */
        .email-header {
            background: #1a1a1a;
            text-align: center;
            padding: 32px 40px;
            border-bottom: 3px solid #536451;
        }
        .email-header .brand { font-size: 28px; font-weight: 900; letter-spacing: 4px; color: #f0ece3; text-transform: uppercase; }
        .email-header .subtitle { font-size: 11px; color: #888; letter-spacing: 2px; text-transform: uppercase; margin-top: 6px; }

        /* ── Body ── */
        .email-body { background: #fff; padding: 40px; border-left: 1px solid #ddd; border-right: 1px solid #ddd; }

        .shipped-banner {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: #f0ece3;
            text-align: center;
            padding: 24px;
            margin-bottom: 32px;
            border-bottom: 3px solid #536451;
        }
        .shipped-banner .icon { font-size: 36px; margin-bottom: 8px; }
        .shipped-banner .shipped-title { font-size: 16px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; color: #f0ece3; }
        .shipped-banner .shipped-sub { font-size: 11px; color: #888; margin-top: 4px; }

        .greeting { font-size: 14px; color: #333; margin-bottom: 12px; }
        .greeting strong { color: #1a1a1a; }
        .intro-text { font-size: 13px; color: #555; margin-bottom: 28px; line-height: 1.7; }

        .section-title {
            font-size: 10px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase;
            color: #536451; border-bottom: 1px solid #e5e5e5; padding-bottom: 8px; margin-bottom: 16px;
        }

        /* ── Tracking Box ── */
        .tracking-box {
            border: 2px solid #1a1a1a;
            padding: 24px;
            text-align: center;
            margin-bottom: 28px;
            background: #fafaf8;
        }
        .tracking-label { font-size: 9px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; color: #888; margin-bottom: 8px; }
        .tracking-number { font-size: 24px; font-weight: 900; letter-spacing: 4px; color: #1a1a1a; font-family: 'Courier New', Courier, monospace; }
        .tracking-hint { font-size: 11px; color: #888; margin-top: 8px; }

        /* ── No Tracking ── */
        .no-tracking-box {
            background: #fafaf8; border: 1px solid #e8e4db; padding: 20px;
            margin-bottom: 28px; text-align: center; font-size: 13px; color: #555;
        }

        /* ── Meta ── */
        .order-meta { background: #fafaf8; border: 1px solid #e8e4db; padding: 20px; margin-bottom: 28px; }
        .meta-row { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; border-bottom: 1px solid #f0ece3; font-size: 13px; }
        .meta-row:last-child { border-bottom: none; }
        .meta-key { color: #777; }
        .meta-val { font-weight: 600; color: #1a1a1a; }

        /* ── Shipping ── */
        .shipping-box { background: #fafaf8; border: 1px solid #e8e4db; padding: 20px; margin-bottom: 28px; }
        .shipping-name { font-size: 14px; font-weight: 700; color: #1a1a1a; margin-bottom: 4px; }
        .shipping-addr { font-size: 12px; color: #555; line-height: 1.7; }
        .shipping-phone { font-size: 12px; color: #555; margin-top: 8px; }

        /* ── Timeline ── */
        .timeline { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 28px; padding: 20px; background: #f9f9f7; border: 1px solid #e5e5e5; }
        .tl-step { display: flex; flex-direction: column; align-items: center; text-align: center; width: 25%; }
        .tl-dot { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 800; margin-bottom: 6px; }
        .tl-dot.done { background: #536451; color: #fff; }
        .tl-dot.active { background: #1a1a1a; color: #fff; }
        .tl-dot.pending { background: #e5e5e5; color: #999; }
        .tl-label { font-size: 9px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; color: #555; }
        .tl-label.active-label { color: #1a1a1a; font-weight: 800; }

        /* ── CTA ── */
        .cta-wrap { text-align: center; margin: 32px 0 24px; }
        .cta-btn { display: inline-block; background: #536451; color: #f0ece3; padding: 14px 32px; text-decoration: none; font-size: 12px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; }

        /* ── Footer ── */
        .email-footer { background: #1a1a1a; text-align: center; padding: 24px 40px; border-top: 3px solid #536451; }
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

        <div class="shipped-banner">
            <div class="icon">🚚</div>
            <div class="shipped-title">Package Dispatched</div>
            <div class="shipped-sub">Your order is on its way!</div>
        </div>

        <p class="greeting">Hello, <strong>{{ $order->name }}</strong></p>
        <p class="intro-text">
            Great news! Your order <strong>#{{ $order->order_id }}</strong> has left our facility and is now in transit to your location.
            Standard delivery takes 3–5 business days.
        </p>

        {{-- Status Timeline --}}
        <div class="timeline">
            <div class="tl-step">
                <div class="tl-dot done">✓</div>
                <div class="tl-label">Ordered</div>
            </div>
            <div class="tl-step">
                <div class="tl-dot done">✓</div>
                <div class="tl-label">Confirmed</div>
            </div>
            <div class="tl-step">
                <div class="tl-dot active">→</div>
                <div class="tl-label active-label">Shipped</div>
            </div>
            <div class="tl-step">
                <div class="tl-dot pending">◯</div>
                <div class="tl-label">Delivered</div>
            </div>
        </div>

        {{-- Tracking --}}
        <div class="section-title">Tracking Information</div>
        @if($order->tracking_number)
        <div class="tracking-box">
            <div class="tracking-label">Your Tracking Number</div>
            <div class="tracking-number">{{ $order->tracking_number }}</div>
            <div class="tracking-hint">Use this number to track your package on the courier's website.</div>
        </div>
        @else
        <div class="no-tracking-box">
            Your package has been dispatched via standard courier. Tracking details will be updated shortly.
        </div>
        @endif

        {{-- Order Meta --}}
        <div class="section-title">Order Details</div>
        <div class="order-meta">
            <div class="meta-row">
                <span class="meta-key">Order ID</span>
                <span class="meta-val">{{ $order->order_id }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-key">Order Total</span>
                <span class="meta-val">₹{{ number_format($order->total_amount, 2) }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-key">Items Ordered</span>
                <span class="meta-val">{{ $order->items->count() }} item(s)</span>
            </div>
        </div>

        {{-- Shipping Address --}}
        <div class="section-title">Delivering To</div>
        <div class="shipping-box">
            <div class="shipping-name">{{ $order->name }}</div>
            <div class="shipping-addr">
                {{ $order->address }}<br>
                {{ $order->city }}, {{ $order->state }} — {{ $order->zip }}
            </div>
            <div class="shipping-phone">📞 {{ $order->phone }}</div>
        </div>

        {{-- CTA --}}
        <div class="cta-wrap">
            <a href="{{ route('orders.show', $order->order_id) }}" class="cta-btn">Track Order Online</a>
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
            This email was sent to {{ $order->email }} regarding order {{ $order->order_id }}.<br>
            © {{ date('Y') }} GET READY. All rights reserved.
        </div>
    </div>

</div>
</body>
</html>
