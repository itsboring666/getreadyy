@extends('layouts.front')
@section('title', 'Thank You | GET READY')

@section('content')

<style>
    .ty-wrapper {
        max-width: var(--max-width);
        margin: 0 auto;
        padding: 24px 16px 64px;
    }
    .ty-columns {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 24px;
        align-items: start;
    }
    @media (max-width: 768px) {
        .ty-columns {
            grid-template-columns: 1fr;
        }
        .ty-aside {
            order: -1; /* Summary appears above items on mobile */
        }
        .ty-header h1 {
            font-size: 22px !important;
        }
        .ty-item-row {
            flex-wrap: wrap;
        }
        .ty-item-price {
            display: none; /* hide duplicated price on mobile */
        }
    }
    .ty-card {
        background: #161616;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 24px;
        margin-bottom: 20px;
    }
    .ty-item-row {
        display: flex;
        gap: 16px;
        align-items: center;
        padding-bottom: 16px;
        margin-bottom: 16px;
        border-bottom: 1px solid var(--border);
    }
    .ty-item-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }
    .ty-summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        font-size: 14px;
    }
</style>

<div class="o-breadcrumb">
    <div class="o-breadcrumb-inner">
        <a href="{{ url('/') }}">Home</a> <span class="sep">/</span>
        <span class="current">Order Complete</span>
    </div>
</div>

<div class="ty-wrapper">

    {{-- Success Header --}}
    <div class="ty-header" style="text-align:center; margin-bottom:32px;">
        <div style="display:inline-flex; align-items:center; justify-content:center; width:72px; height:72px; border-radius:50%; background:rgba(153,27,27,0.15); color:var(--primary); margin-bottom:20px;">
            <i class="fas fa-check-circle" style="font-size:36px;"></i>
        </div>
        <h1 style="font-family:var(--font-heading); font-size:28px; font-weight:700; color:var(--text); margin-bottom:10px;">Thank you for your order!</h1>
        <p style="color:var(--text-secondary); max-width:560px; margin:0 auto; font-size:14px; line-height:1.6;">
            We've received your order and are currently processing it. A confirmation email has been sent to
            <span style="font-weight:600; color:var(--text);">{{ $order->email }}</span>.
        </p>
    </div>

    <div class="ty-columns">

        {{-- Left Column: Order Items --}}
        <div>
            <div class="ty-card">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; padding-bottom:16px; border-bottom:1px solid var(--border);">
                    <h2 style="font-family:var(--font-heading); font-size:18px; font-weight:600; color:var(--text); margin:0;">Order Items</h2>
                    <span style="padding:4px 12px; border-radius:30px; font-size:12px; font-weight:600; background:var(--bg); color:var(--primary);">
                        {{ $order->items->count() }} Items
                    </span>
                </div>

                @foreach ($order->items as $item)
                @php $product = $item->product; @endphp
                <div class="ty-item-row">
                    <div style="width:72px; height:90px; flex-shrink:0; position:relative; border:1px solid var(--border); border-radius:4px; overflow:hidden; background:#1a1a1a;">
                        <img src="{{ get_storage_url($product->image) }}" alt="{{ $item->product_name }}" style="width:100%; height:100%; object-fit:cover;">
                        <span style="position:absolute; top:0; right:0; background:var(--text); color:var(--white); font-size:10px; padding:2px 5px; border-bottom-left-radius:4px; font-weight:bold;">{{ $item->quantity }}</span>
                    </div>
                    <div style="flex:1; min-width:0;">
                        <h3 style="font-weight:600; font-size:15px; color:var(--text); margin:0 0 4px 0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $item->product_name }}</h3>
                        <p style="font-size:12px; color:var(--text-secondary); margin:0 0 6px 0;">Size: <span style="font-weight:600; color:var(--text);">{{ $item->size }}</span></p>
                        <p style="font-weight:600; font-size:14px; color:var(--text); margin:0;">₹{{ number_format($item->price * $item->quantity, 2) }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Shipping Info --}}
            <div class="ty-card">
                <h3 style="font-family:var(--font-heading); font-size:16px; font-weight:600; color:var(--text); margin:0 0 16px 0;">Shipping Information</h3>
                <div style="font-size:14px; color:var(--text-secondary); line-height:1.7;">
                    <p style="font-weight:600; color:var(--text); font-size:15px; margin:0 0 4px 0;">{{ $order->name }}</p>
                    <p style="margin:0 0 2px 0;">{{ $order->address }}</p>
                    <p style="margin:0 0 12px 0;">{{ $order->city }}, {{ $order->state }} {{ $order->zip }}</p>
                    <p style="margin:0 0 4px 0; display:flex; align-items:center; gap:8px;"><i class="fas fa-phone" style="color:#9ca3af; width:16px;"></i> {{ $order->phone }}</p>
                    <p style="margin:0; display:flex; align-items:center; gap:8px;"><i class="fas fa-envelope" style="color:#9ca3af; width:16px;"></i> {{ $order->email }}</p>
                </div>
            </div>
        </div>

        {{-- Right Column: Order Summary --}}
        <aside class="ty-aside">
            <div class="o-order-summary">
                <h3 style="margin-bottom:20px; padding-bottom:16px; border-bottom:1px solid var(--border); font-size:18px;">Order Summary</h3>

                <div style="margin-bottom:20px; padding-bottom:20px; border-bottom:1px solid var(--border);">
                    <div class="ty-summary-row">
                        <span style="color:var(--text-secondary);">Order ID</span>
                        <span style="font-weight:600; color:var(--text); font-size:13px;">{{ $order->order_id }}</span>
                    </div>
                    <div class="ty-summary-row">
                        <span style="color:var(--text-secondary);">Date</span>
                        <span style="font-weight:600; color:var(--text);">{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="ty-summary-row">
                        <span style="color:var(--text-secondary);">Payment Status</span>
                        <span style="font-weight:600; color:#16a34a; text-transform:capitalize;">{{ $order->status }}</span>
                    </div>
                </div>

                <div class="ty-summary-row" style="margin-bottom:24px;">
                    <span style="font-size:16px; font-weight:600;">Total Amount</span>
                    <span style="color:var(--accent); font-size:22px; font-weight:700;">₹{{ number_format($order->total_amount, 2) }}</span>
                </div>

                <a href="{{ route('order.invoice.download', ['orderId' => $order->order_id]) }}" class="o-btn o-btn-primary o-btn-full o-btn-lg" style="margin-bottom:12px;">
                    <i class="fas fa-file-invoice" style="margin-right:8px;"></i> Download Invoice
                </a>
            </div>
        </aside>

    </div>

    <div style="text-align:center; margin-top:8px;">
        <a href="{{ route('products.all') }}" style="color:var(--primary); font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:color 0.2s;">
            <i class="fas fa-arrow-left"></i> Continue Shopping
        </a>
    </div>

</div>

@endsection