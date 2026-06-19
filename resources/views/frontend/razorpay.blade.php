@extends('layouts.front')
@section('title', 'Razorpay Checkout | GET READY')

@section('content')
<div class="gr-wardrobe" style="padding: 60px 24px 100px;">
    <div style="max-width: 600px; margin: 0 auto;">
        
        <div style="margin-bottom: 24px;">
            <a href="{{ route('checkout') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em;">
                <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> ABORT TRANSACTION
            </a>
        </div>

        <div style="margin-bottom: 32px; border-bottom: 3px double var(--text); padding-bottom: 16px;">
            <div style="font-family: var(--font); font-size: 10px; font-weight: 700; color: var(--accent); letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 8px;">RAZORPAY PAYMENT GATEWAY</div>
            <h1 style="font-family: var(--font-heading); font-size: 32px; font-weight: 700; color: var(--text); margin: 0; letter-spacing: 0.05em;">SECURE TRANSACTION SYSTEM</h1>
        </div>

        <div style="background: #161616; border: 1px solid var(--border); box-shadow: 5px 5px 0px rgba(153,27,27,0.35); padding: 40px; margin-bottom: 32px;">
            <div style="background: var(--bg); border: 1px dashed var(--text); padding: 20px; margin-bottom: 32px; font-family: monospace; font-size: 13px; line-height: 1.6;">
                <span style="display: block; font-weight: bold;">TXN REF: {{ $order->order_id }}</span>
                <span style="display: block;">RECIPIENT: {{ $order->name }}</span>
                <span style="display: block;">TELEMETRY: {{ $order->email }}</span>
                <span style="display: block; margin-top: 12px; border-top: 1px dashed var(--text); padding-top: 12px; font-size: 16px; font-weight: bold; color: var(--accent);">AMOUNT DUE: ₹{{ number_format($order->total_amount, 2) }}</span>
            </div>

            @if ($errors->any())
                <div style="background: #1a0808; border: 1px solid #7f1d1d; color: #fca5a5; padding: 16px; margin-bottom: 24px; font-family: var(--font); font-size: 13px;">
                    <strong>ERRORS DETECTED:</strong>
                    <ul style="margin: 8px 0 0 16px; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(str_starts_with($razorpayOrderId, 'mock_'))
                <!-- Mock Checkout Flow -->
                <form action="{{ route('checkout.razorpay.process', $order->order_id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="razorpay_payment_id" value="pay_mock_{{ uniqid() }}">
                    <input type="hidden" name="razorpay_order_id" value="{{ $razorpayOrderId }}">
                    <input type="hidden" name="razorpay_signature" value="sig_mock_{{ uniqid() }}">

                    <div style="text-align: center; margin-bottom: 32px; font-family: monospace; font-size: 13px; color: var(--text-secondary);">
                        ⚠️ RAZORPAY KEYS ARE NOT CONFIGURED. SYSTEM RUNNING IN SANDBOX MOCK MODE.
                    </div>

                    <button type="submit" class="gr-hero-btn-primary" style="width: 100%; justify-content: center; background: var(--text); padding: 16px; font-size: 12px;">
                        <i class="fas fa-shield-alt" style="margin-right: 8px;"></i> AUTHORIZE MOCK TRANSACTION →
                    </button>
                </form>
            @else
                <!-- Real Razorpay Elements Flow -->
                <div style="text-align: center; margin-bottom: 32px;">
                    <p style="font-family: var(--font); font-size: 14px; color: var(--text); margin-bottom: 24px;">
                        Click below to open the Razorpay secure payment interface.
                    </p>
                    <button id="rzp-button1" class="gr-hero-btn-primary" style="width: 100%; justify-content: center; background: var(--text); padding: 16px; font-size: 12px;">
                        <i class="fas fa-credit-card" style="margin-right: 8px;"></i> INITIALIZE PAYMENT PROCESSOR →
                    </button>
                </div>

                <form id="razorpay-form" action="{{ route('checkout.razorpay.process', $order->order_id) }}" method="POST" style="display: none;">
                    @csrf
                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                    <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                    <input type="hidden" name="razorpay_signature" id="razorpay_signature">
                </form>

                <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const options = {
                            "key": "{{ $razorpayKey }}",
                            "amount": "{{ round($order->total_amount * 100) }}",
                            "currency": "INR",
                            "name": "GET READY",
                            "description": "Order Ref: {{ $order->order_id }}",
                            "order_id": "{{ $razorpayOrderId }}",
                            "handler": function (response) {
                                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                                document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                                document.getElementById('razorpay_signature').value = response.razorpay_signature;
                                document.getElementById('razorpay-form').submit();
                            },
                            "prefill": {
                                "name": "{{ $order->name }}",
                                "email": "{{ $order->email }}",
                                "contact": "{{ $order->phone }}"
                            },
                            "theme": {
                                "color": "#536451"
                            }
                        };
                        const rzp = new Razorpay(options);

                        document.getElementById('rzp-button1').onclick = function (e) {
                            rzp.open();
                            e.preventDefault();
                        }

                        // Auto-open modal on page load for a smoother UX
                        setTimeout(() => {
                            rzp.open();
                        }, 500);
                    });
                </script>
            @endif
        </div>

        <div style="text-align: center; font-family: monospace; font-size: 11px; color: var(--text-secondary); line-height: 1.6;">
            🔒 TRANSMISSION IS ENCRYPTED VIA SECURE GATEWAY PROTOCOLS.
        </div>

    </div>
</div>
@endsection
