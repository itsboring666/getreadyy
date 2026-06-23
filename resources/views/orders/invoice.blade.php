<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $order->order_id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #1a1a1a;
            line-height: 1.5;
            background-color: #fff;
        }
        .invoice-wrap {
            max-width: 780px;
            margin: 0 auto;
            background: #fff;
        }

        /* ── Header ── */
        .invoice-header {
            width: 100%;
            background: #000;
            padding: 0;
            line-height: 0;
        }
        .invoice-header img {
            width: 100%;
            height: auto;
            display: block;
        }
        .header-address {
            background: #111;
            color: #ccc;
            text-align: center;
            font-size: 9px;
            letter-spacing: 1px;
            padding: 6px 20px 10px;
            line-height: 1.6;
            text-transform: uppercase;
        }

        /* ── Body ── */
        .invoice-body { padding: 36px 50px; }

        .invoice-label {
            text-align: center;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 3px;
            margin-bottom: 30px;
            text-transform: uppercase;
            color: #333;
        }

        /* Issued To / Invoice No */
        .meta-row { width: 100%; margin-bottom: 20px; }
        .meta-row td { vertical-align: top; padding: 0; }
        .meta-label {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .meta-value { font-size: 11px; color: #333; line-height: 1.6; }

        /* Divider */
        .divider { border: none; border-top: 1px solid #aaa; margin: 16px 0; }

        /* Items Table */
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 0; }
        .items-table thead tr th {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 10px 6px;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            background: #fff;
        }
        .items-table tbody tr td {
            font-size: 11px;
            padding: 10px 6px;
            border-bottom: 1px solid #eee;
            color: #333;
        }
        .items-table tbody tr:last-child td { border-bottom: none; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* Shipping row */
        .shipping-row {
            width: 100%;
            text-align: right;
            font-size: 11px;
            color: #555;
            padding: 6px 6px 0;
        }

        /* Total Block */
        .total-label-row {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 10px 6px;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            margin-top: 8px;
        }
        .grand-total-row {
            text-align: right;
            font-size: 12px;
            padding: 10px 6px;
            color: #111;
        }

        /* Footer */
        .invoice-footer { padding: 20px 50px 40px; }
        .contact-line {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
        .footer-row { width: 100%; }
        .footer-row td { vertical-align: middle; }
        .qr-img { width: 72px; height: 72px; border: 1px solid #ccc; display: block; }
        .qr-handle { font-size: 8px; font-weight: 700; letter-spacing: 0.5px; margin-top: 3px; }
        .thankyou {
            text-align: center;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
<div class="invoice-wrap">

    {{-- ── HEADER ── --}}
    <div class="invoice-header">
        <img src="{{ public_path('assets/images/official-logo.jpg') }}" alt="GET READY">
    </div>
    <div class="header-address">
        NO 19/1 TMS SCHOOL (OPP) 2<sup>ND</sup> MAINROAD 2<sup>ND</sup> CROSS STREET , RAILNAGAR ,<br>
        MARAMALAINAGAR, CHENGALPATTU TAMILNADU 603203
    </div>

    {{-- ── BODY ── --}}
    <div class="invoice-body">
        <div class="invoice-label">INVOICE</div>

        {{-- Issued To / Invoice No / Date --}}
        <table class="meta-row">
            <tr>
                <td style="width:50%;">
                    <div class="meta-label">ISSUED TO:</div>
                    <div class="meta-value">
                        {{ $order->name }}<br>
                        {{ $order->address }}<br>
                        {{ $order->city }}, {{ $order->state }}<br>
                        {{ $order->zip }}
                    </div>
                </td>
                <td style="width:50%; text-align:right;">
                    <div class="meta-label">INVOICE NO:</div>
                    <div class="meta-value" style="margin-bottom:12px;">{{ $order->order_id }}</div>
                    <div class="meta-label">DATE:</div>
                    <div class="meta-value">{{ $order->created_at->setTimezone('Asia/Kolkata')->format('d/m/Y') }}</div>
                </td>
            </tr>
        </table>

        <hr class="divider">

        {{-- Items Table --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width:45%; text-align:left;">DESCRIPTION</th>
                    <th class="text-right">UNIT PRICE</th>
                    <th class="text-center">QTY</th>
                    <th class="text-right">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                <tr>
                    <td>{{ strtoupper($item->product_name) }} - {{ strtoupper($item->size) }}</td>
                    <td class="text-right">₹{{ number_format($item->price, 2) }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Shipping / Discount --}}
        @php
            $shipping = $order->shipping_fee ?? 0;
            $discount = $order->discount_amount ?? 0;
        @endphp
        @if($shipping > 0)
        <div class="shipping-row">Shipping: ₹{{ number_format($shipping, 2) }}</div>
        @endif
        @if($discount > 0)
        <div class="shipping-row" style="color:#c2410c;">Discount ({{ $order->coupon_code ?? '' }}): -₹{{ number_format($discount, 2) }}</div>
        @endif

        {{-- Total --}}
        <div class="total-label-row">TOTAL</div>
        <div class="grand-total-row">Total &nbsp;&nbsp;&nbsp; ₹{{ number_format($order->total_amount, 2) }}</div>
    </div>

    {{-- ── FOOTER ── --}}
    <div class="invoice-footer">
        <div class="contact-line">CONTACT : 9080253885</div>
        <table class="footer-row">
            <tr>
                <td style="width:100px;">
                    <img class="qr-img"
                         src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=https://www.instagram.com/_getreadyyyy"
                         alt="Instagram QR">
                    <div class="qr-handle">_GETREADYYYY</div>
                </td>
                <td>
                    <div class="thankyou">THANKYOU FOR PURCHASING.</div>
                </td>
            </tr>
        </table>
    </div>

</div>
</body>
</html>