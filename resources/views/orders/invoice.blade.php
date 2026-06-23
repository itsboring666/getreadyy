<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $order->order_id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 13px; color: #1a1a1a; line-height: 1.5; background-color: #fff; }
        .invoice-container { max-width: 800px; margin: 0 auto; background: #fff; }

        /* Header Area */
        .header-section {
            background-color: #111;
            color: #fff;
            text-align: center;
            padding: 40px 20px 20px 20px;
            position: relative;
        }
        .header-title {
            font-family: 'Arial Black', Impact, sans-serif;
            font-size: 64px;
            color: #e53e3e; /* Red color */
            margin: 0;
            line-height: 1;
            letter-spacing: -2px;
            text-transform: uppercase;
        }
        .header-subtitle {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 2px;
            margin-top: 5px;
            margin-bottom: 15px;
        }
        .header-address {
            font-size: 10px;
            letter-spacing: 1px;
            color: #ccc;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.4;
        }

        /* Content Area */
        .content-section {
            padding: 40px 50px;
        }

        .invoice-label {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 40px;
            color: #333;
        }

        /* Top Details */
        .details-grid {
            width: 100%;
            margin-bottom: 30px;
        }
        .details-grid td {
            vertical-align: top;
            width: 50%;
        }
        .block-title {
            font-weight: bold;
            font-size: 12px;
            letter-spacing: 1px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        /* Table */
        table.items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.items-table th, table.items-table td {
            padding: 12px 5px;
            text-align: left;
        }
        table.items-table th {
            font-weight: bold;
            font-size: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }
        table.items-table .text-right { text-align: right; }
        table.items-table .text-center { text-align: center; }

        /* Total Section */
        .total-section {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 12px 5px;
            margin-bottom: 10px;
        }
        .total-label {
            font-weight: bold;
            font-size: 12px;
            letter-spacing: 1px;
        }
        .grand-total {
            text-align: right;
            padding-right: 5px;
            font-size: 14px;
            margin-bottom: 60px;
        }

        /* Footer */
        .footer-section {
            position: relative;
            margin-top: 60px;
        }
        .contact-info {
            font-weight: bold;
            font-size: 12px;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        .qr-box {
            width: 80px;
            height: 80px;
            background: #eee;
            border: 1px solid #ccc;
            display: inline-block;
            margin-bottom: 5px;
            text-align: center;
        }
        .qr-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .qr-label {
            font-size: 9px;
            font-weight: bold;
        }
        .thank-you {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            letter-spacing: 1px;
            margin-top: -30px; /* pull up alongside QR */
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        
        <!-- Header -->
        <div class="header-section">
            <h1 class="header-title">GET READY</h1>
            <div class="header-subtitle">MEN'S CLOTHING STORE</div>
            <div class="header-address">
                NO 19/1 TMS SCHOOL (OPP) 2ND MAINROAD 2ND CROSS STREET, RAILNAGAR, <br>
                MARAMALAINAGAR, CHENGALPATTU TAMILNADU 603203
            </div>
        </div>

        <div class="content-section">
            <div class="invoice-label">INVOICE</div>

            <table class="details-grid">
                <tr>
                    <td>
                        <div class="block-title">ISSUED TO:</div>
                        <div>{{ $order->name }}</div>
                        <div>{{ $order->address }}</div>
                        <div>{{ $order->city }}, {{ $order->state }} - {{ $order->zip }}</div>
                    </td>
                    <td>
                        <div style="margin-bottom: 15px;">
                            <span class="block-title">INVOICE NO:</span> {{ $order->order_id }}
                        </div>
                        <div>
                            <span class="block-title">DATE:</span> {{ $order->created_at->setTimezone('Asia/Kolkata')->format('d/m/Y') }}
                        </div>
                    </td>
                </tr>
            </table>

            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 50%;">DESCRIPTION</th>
                        <th class="text-right">UNIT PRICE</th>
                        <th class="text-center">QTY</th>
                        <th class="text-right">TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }} - {{ $item->size }}</td>
                        <td class="text-right">₹{{ number_format($item->price, 2) }}</td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">₹{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @php
                $shipping = $order->shipping_fee ?? 0.00;
                $discount = $order->discount_amount ?? 0.00;
            @endphp

            @if($shipping > 0 || $discount > 0)
                <div style="text-align: right; padding-right: 5px; margin-bottom: 10px; font-size: 12px;">
                    @if($shipping > 0)
                        <div>Shipping: ₹{{ number_format($shipping, 2) }}</div>
                    @endif
                    @if($discount > 0)
                        <div>Discount: -₹{{ number_format($discount, 2) }}</div>
                    @endif
                </div>
            @endif

            <div class="total-section">
                <span class="total-label">TOTAL</span>
            </div>
            
            <div class="grand-total">
                Total &nbsp;&nbsp;&nbsp; ₹{{ number_format($order->total_amount, 2) }}
            </div>

            <div class="footer-section">
                <div class="contact-info">CONTACT : 9080253885</div>
                <div>
                    <!-- Optional: You can place a real QR code image here if you have one -->
                    <div class="qr-box">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https://www.instagram.com/_getreadyyyy" alt="QR Code">
                    </div>
                    <div class="qr-label">_GETREADYYYY</div>
                </div>

                <div class="thank-you">
                    THANKYOU FOR PURCHASING.
                </div>
            </div>
        </div>
    </div>
</body>
</html>