@extends('layouts.front')
@section('title', 'Thank You | GET READY')

@section('content')

<div class="o-breadcrumb">
    <div class="o-breadcrumb-inner">
        <a href="{{ url('/') }}">Home</a> <span class="sep">/</span> 
        <span class="current">Order Complete</span>
    </div>
</div>

<div class="o-cart-layout" style="margin-top:24px; margin-bottom:64px;">
    
    {{-- Success Header --}}
    <div style="grid-column: 1 / -1; text-align:center; margin-bottom:32px;">
        <div style="display:inline-flex; align-items:center; justify-content:center; width:80px; height:80px; border-radius:50%; background:rgba(153,27,27,0.15); color:var(--primary); margin-bottom:24px;">
            <i class="fas fa-check-circle" style="font-size:40px;"></i>
        </div>
        <h1 style="font-family:var(--font-heading); font-size:32px; font-weight:700; color:var(--text); margin-bottom:12px;">Thank you for your order!</h1>
        <p style="color:var(--text-secondary); max-width:600px; margin:0 auto;">We've received your order and are currently processing it. A confirmation email has been sent to <span style="font-weight:600; color:var(--text);">{{ $order->email }}</span>.</p>
    </div>

    {{-- Left Column: Order Summary & Items --}}
    <div style="grid-column: span 8;">
        
        <div style="background:#161616; border:1px solid var(--border); border-radius:var(--radius); padding:32px; margin-bottom:24px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; padding-bottom:16px; border-bottom:1px solid var(--border);">
                <h2 style="font-family:var(--font-heading); font-size:20px; font-weight:600; color:var(--text); margin:0;">Order Items</h2>
                <span style="padding:4px 12px; border-radius:30px; font-size:12px; font-weight:600; background:var(--bg); color:var(--primary);">
                    {{ $order->items->count() }} Items
                </span>
            </div>
            
            <div>
                @foreach ($order->items as $item)
                @php $product = $item->product; @endphp
                <div style="display:flex; gap:20px; align-items:center; margin-bottom:20px; padding-bottom:20px; border-bottom:1px solid rgba(0,0,0,0.05);">
                    <div style="width:80px; height:100px; position:relative; border:1px solid var(--border); border-radius:4px; overflow:hidden; background:#1a1a1a; flex-shrink:0;">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $item->product_name }}" style="width:100%; height:100%; object-fit:cover;">
                        <span style="position:absolute; top:0; right:0; background:var(--text); color:var(--white); font-size:11px; padding:2px 6px; border-bottom-left-radius:4px; font-weight:bold;">{{ $item->quantity }}</span>
                    </div>
                    <div style="flex:1;">
                        <h3 style="font-weight:600; font-size:16px; color:var(--text); margin:0 0 4px 0;">{{ $item->product_name }}</h3>
                        <p style="font-size:13px; color:var(--text-secondary); margin:0 0 8px 0;">Size: <span style="font-weight:600; color:var(--text);">{{ $item->size }}</span></p>
                        <p style="font-weight:500; font-size:14px; color:var(--text); margin:0;">₹{{ number_format($item->price, 2) }}</p>
                    </div>
                    <div style="text-align:right;">
                        <p style="font-weight:600; font-size:16px; color:var(--text); margin:0;">₹{{ number_format($item->price * $item->quantity, 2) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Right Column: Order Details & Actions --}}
    <aside style="grid-column: span 4; height:fit-content;">
        
        <div class="o-order-summary" style="margin-bottom:24px;">
            <h3 style="margin-bottom:20px; padding-bottom:16px; border-bottom:1px solid var(--border); font-size:18px;">Order Summary</h3>
            
            <div style="margin-bottom:24px; padding-bottom:24px; border-bottom:1px solid var(--border);">
                <div class="o-summary-row" style="margin-bottom:12px;">
                    <span style="color:var(--text-secondary);">Order ID</span>
                    <span style="font-weight:600; color:var(--text);">{{ $order->order_id }}</span>
                </div>
                <div class="o-summary-row" style="margin-bottom:12px;">
                    <span style="color:var(--text-secondary);">Date</span>
                    <span style="font-weight:600; color:var(--text);">{{ $order->created_at->format('M d, Y') }}</span>
                </div>
                <div class="o-summary-row">
                    <span style="color:var(--text-secondary);">Payment Status</span>
                    <span style="font-weight:600; color:#16a34a; text-transform:capitalize;">{{ $order->status }}</span>
                </div>
            </div>

            <div class="o-summary-row total" style="margin-bottom:24px;">
                <span style="font-size:16px;">Total Amount</span>
                <span style="color:var(--accent); font-size:24px;">₹{{ number_format($order->total_amount, 2) }}</span>
            </div>

            <a href="{{ route('order.invoice.download', ['orderId' => $order->order_id]) }}" class="o-btn o-btn-primary o-btn-full o-btn-lg">
                <i class="fas fa-file-invoice" style="margin-right:8px;"></i> Download Invoice
            </a>
        </div>

        <div style="background:var(--bg); border:1px solid var(--border); border-radius:var(--radius); padding:24px;">
            <h3 style="font-family:var(--font-heading); font-size:16px; font-weight:600; color:var(--text); margin:0 0 16px 0;">Shipping Information</h3>
            <div style="font-size:14px; color:var(--text-secondary); line-height:1.6;">
                <p style="font-weight:600; color:var(--text); font-size:15px; margin:0 0 4px 0;">{{ $order->name }}</p>
                <p style="margin:0 0 2px 0;">{{ $order->address }}</p>
                <p style="margin:0 0 12px 0;">{{ $order->city }}, {{ $order->state }} {{ $order->zip }}</p>
                <p style="margin:0 0 4px 0; display:flex; align-items:center;"><i class="fas fa-phone" style="width:20px; color:#9ca3af;"></i> {{ $order->phone }}</p>
                <p style="margin:0; display:flex; align-items:center;"><i class="fas fa-envelope" style="width:20px; color:#9ca3af;"></i> {{ $order->email }}</p>
            </div>
        </div>

    </aside>

    <div style="grid-column: 1 / -1; text-align:center; margin-top:16px;">
        <a href="{{ route('products.all') }}" style="color:var(--primary); font-weight:600; text-decoration:none; display:inline-flex; align-items:center; transition:color 0.2s;">
            <i class="fas fa-arrow-left" style="margin-right:8px;"></i> Continue Shopping
        </a>
    </div>

</div>

@endsection