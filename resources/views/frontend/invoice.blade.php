<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice — {{ $order->order_id }} | GET READY</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            line-height: 1.5;
            background: #fff;
        }
        .invoice-wrap { max-width: 800px; margin: 0 auto; background: #fff; }

        /* ──────── HEADER ──────── */
        .invoice-header { background: #000; padding: 0; line-height: 0; }
        .invoice-header img { width: 100%; height: auto; display: block; }
        .header-sub {
            background: #111; color: #aaa; text-align: center;
            font-size: 8px; letter-spacing: 2px; padding: 6px 20px 10px;
            line-height: 1.8; text-transform: uppercase;
        }
        .header-sub strong { color: #ddd; }

        /* ──────── BODY ──────── */
        .invoice-body { padding: 40px 52px 28px; }
        .invoice-label {
            text-align: center; font-size: 14px; font-weight: 800;
            letter-spacing: 4px; margin-bottom: 28px; text-transform: uppercase;
            color: #1a1a1a; border-bottom: 2px solid #000; padding-bottom: 14px;
        }

        /* ──────── META TABLE ──────── */
        .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .meta-table td { vertical-align: top; padding: 0; }
        .meta-label { font-size: 9px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; color: #666; margin-bottom: 4px; }
        .meta-value { font-size: 11px; color: #1a1a1a; line-height: 1.7; }
        .meta-value strong { font-size: 12px; }
        .payment-badge {
            display: inline-block; background: #1a1a1a; color: #fff;
            font-size: 8px; font-weight: 800; letter-spacing: 1px;
            text-transform: uppercase; padding: 3px 8px; margin-top: 6px;
        }

        /* ──────── DIVIDERS ──────── */
        .divider { border: none; border-top: 1px solid #ccc; margin: 20px 0; }

        /* ──────── ITEMS TABLE ──────── */
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 0; }
        .items-table thead tr th {
            font-size: 9px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase;
            padding: 10px 8px; border-top: 2px solid #1a1a1a; border-bottom: 2px solid #1a1a1a;
            background: #fff; color: #1a1a1a;
        }
        .items-table tbody tr td {
            font-size: 11px; padding: 11px 8px; border-bottom: 1px solid #eee; color: #333; vertical-align: top;
        }
        .items-table tbody tr:last-child td { border-bottom: 1px solid #ccc; }
        .item-name { font-weight: 600; font-size: 11px; color: #1a1a1a; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* ──────── TOTALS ──────── */
        .totals-wrap { padding: 16px 0 0; }
        .totals-row { display: flex; justify-content: flex-end; align-items: center; margin-bottom: 6px; }
        .totals-label { font-size: 10px; color: #666; text-transform: uppercase; letter-spacing: 0.5px; text-align: right; width: 180px; padding-right: 16px; }
        .totals-value { font-size: 11px; color: #1a1a1a; text-align: right; width: 90px; }
        .totals-row.discount .totals-label, .totals-row.discount .totals-value { color: #b45309; }
        .grand-total-row { display: flex; justify-content: flex-end; align-items: center; border-top: 2px solid #1a1a1a; padding-top: 10px; margin-top: 8px; }
        .grand-total-label { font-size: 11px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; color: #1a1a1a; text-align: right; width: 180px; padding-right: 16px; }
        .grand-total-value { font-size: 16px; font-weight: 800; color: #1a1a1a; text-align: right; width: 90px; }

        /* ──────── STATUS SECTION ──────── */
        .status-section { margin-top: 24px; padding: 12px 16px; border: 1px solid #e5e5e5; background: #fafafa; }
        .status-grid { display: flex; gap: 32px; flex-wrap: wrap; }
        .status-key { font-size: 8px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; color: #999; margin-bottom: 2px; }
        .status-val { font-size: 11px; color: #1a1a1a; font-weight: 600; }

        /* ──────── FOOTER ──────── */
        .invoice-footer { padding: 20px 52px 36px; border-top: 1px solid #ddd; }
        .contact-line { font-size: 9px; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; color: #555; margin-bottom: 14px; }
        .footer-row { width: 100%; border-collapse: collapse; }
        .footer-row td { vertical-align: middle; }
        .qr-img { width: 68px; height: 68px; border: 1px solid #ccc; display: block; }
        .qr-handle { font-size: 7px; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase; color: #555; margin-top: 4px; text-align: center; }
        .thankyou { text-align: center; font-size: 12px; font-weight: 800; letter-spacing: 3px; text-transform: uppercase; color: #1a1a1a; }
        .thankyou small { display: block; font-size: 9px; font-weight: 400; color: #888; letter-spacing: 1px; margin-top: 4px; }
        .footer-note { text-align: center; font-size: 8px; color: #aaa; letter-spacing: 0.5px; margin-top: 16px; padding-top: 12px; border-top: 1px solid #eee; }
    </style>
</head>
<body>
<div class="invoice-wrap">

    {{-- ── HEADER ── --}}
    <div class="invoice-header">
        <img src="{{ $logoBase64 }}" alt="GET READY">
    </div>
    <div class="header-sub">
        <strong>GET READY</strong> &nbsp;|&nbsp; Coimbatore, Tamil Nadu &nbsp;|&nbsp; Ph: +91 9080253885 &nbsp;|&nbsp; @_getreadyyyy
    </div>

    {{-- ── BODY ── --}}
    <div class="invoice-body">

        <div class="invoice-label">TAX INVOICE</div>

        {{-- ── META ── --}}
        <table class="meta-table">
            <tr>
                <td style="width: 55%;">
                    <div class="meta-label">Billed To</div>
                    <div class="meta-value">
                        <strong>{{ strtoupper($order->name) }}</strong><br>
                        {{ $order->address }}<br>
                        {{ $order->city }}, {{ $order->state }} — {{ $order->zip }}<br>
                        Ph: {{ $order->phone }}<br>
                        @if($order->email){{ $order->email }}@endif
                    </div>
                </td>
                <td style="width: 45%; text-align: right;">
                    <div class="meta-label">Invoice No.</div>
                    <div class="meta-value" style="margin-bottom: 10px;">
                        <strong>{{ $order->order_id }}</strong>
                    </div>
                    <div class="meta-label">Invoice Date</div>
                    <div class="meta-value" style="margin-bottom: 10px;">
                        {{ $order->created_at->setTimezone('Asia/Kolkata')->format('d F Y') }}
                    </div>
                    <div class="meta-label">Order Status</div>
                    <div class="meta-value">
                        <span class="payment-badge">{{ strtoupper($order->status) }}</span>
                    </div>
                </td>
            </tr>
        </table>

        <hr class="divider">

        {{-- ── ITEMS TABLE ── --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%; text-align: left;">Item Description</th>
                    <th style="width: 10%;" class="text-center">Size</th>
                    <th style="width: 10%;" class="text-center">Qty</th>
                    <th style="width: 15%;" class="text-right">Unit Price</th>
                    <th style="width: 15%;" class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                <tr>
                    <td><div class="item-name">{{ strtoupper($item->product_name) }}</div></td>
                    <td class="text-center">{{ $item->size }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">Rs. {{ number_format($item->price, 2) }}</td>
                    <td class="text-right">Rs. {{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ── TOTALS ── --}}
        @php
            $shipping = $order->shipping_fee ?? 0;
            $discount = $order->discount_amount ?? 0;
            $subtotal = $order->total_amount - $shipping + $discount;
        @endphp
        <div class="totals-wrap">
            <div class="totals-row">
                <div class="totals-label">Subtotal</div>
                <div class="totals-value">Rs. {{ number_format($subtotal, 2) }}</div>
            </div>
            <div class="totals-row">
                <div class="totals-label">Shipping</div>
                <div class="totals-value">{{ $shipping > 0 ? 'Rs. ' . number_format($shipping, 2) : 'FREE' }}</div>
            </div>
            @if($discount > 0)
            <div class="totals-row discount">
                <div class="totals-label">Discount{{ $order->coupon_code ? ' (' . $order->coupon_code . ')' : '' }}</div>
                <div class="totals-value">— Rs. {{ number_format($discount, 2) }}</div>
            </div>
            @endif
            <div class="grand-total-row">
                <div class="grand-total-label">Grand Total</div>
                <div class="grand-total-value">Rs. {{ number_format($order->total_amount, 2) }}</div>
            </div>
        </div>

        {{-- ── ORDER DETAILS ── --}}
        <div class="status-section">
            <div class="status-grid">
                <div class="status-item">
                    <div class="status-key">Payment Mode</div>
                    <div class="status-val">
                        @if(in_array(strtolower($order->status), ['paid', 'shipped', 'delivered']))
                            Online Payment
                        @else
                            {{ strtoupper($order->status) }}
                        @endif
                    </div>
                </div>
                <div class="status-item">
                    <div class="status-key">Order Date</div>
                    <div class="status-val">{{ $order->created_at->setTimezone('Asia/Kolkata')->format('d/m/Y h:i A') }}</div>
                </div>
                @if($order->tracking_number)
                <div class="status-item">
                    <div class="status-key">Tracking No.</div>
                    <div class="status-val" style="font-family: monospace;">{{ $order->tracking_number }}</div>
                </div>
                @endif
                <div class="status-item">
                    <div class="status-key">Total Items</div>
                    <div class="status-val">{{ $order->items->count() }}</div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── FOOTER ── --}}
    <div class="invoice-footer">
        <div class="contact-line">CONTACT US &nbsp;|&nbsp; +91 9080253885 &nbsp;|&nbsp; @_getreadyyyy</div>
        <table class="footer-row">
            <tr>
                <td style="width: 90px;">
                    <img class="qr-img"
                         src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=https://www.instagram.com/_getreadyyyy"
                         alt="Instagram QR">
                    <div class="qr-handle">@_getreadyyyy</div>
                </td>
                <td style="padding: 0 24px;">
                    <div class="thankyou">
                        THANK YOU FOR PURCHASING.
                        <small>Heavy fabrics. Honest stitching. Pieces that earn their fade.</small>
                    </div>
                </td>
            </tr>
        </table>
        <div class="footer-note">
            This is a computer-generated invoice and does not require a physical signature.
            For queries, contact us via WhatsApp or email.
        </div>
    </div>

</div>
</body>
</html>