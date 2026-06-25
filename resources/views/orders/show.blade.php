@extends('layouts.front')
@section('title', 'Order #' . $order->order_id . ' | GET READY')

@section('content')

<div class="gr-wardrobe" style="padding: 60px 24px 100px;">
    <div style="max-width: 1000px; margin: 0 auto;">
        
        <div style="margin-bottom: 24px;">
            <a href="{{ route('orders.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em;">
                <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> BACK TO LOG
            </a>
        </div>

        @if(session('success'))
        <div style="background: rgba(40,167,69,0.1); border: 1px solid #28a745; color: #28a745; padding: 16px; margin-bottom: 24px; font-weight: 600;">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div style="background: rgba(220,53,69,0.1); border: 1px solid #dc3545; color: #dc3545; padding: 16px; margin-bottom: 24px; font-weight: 600;">
            {{ session('error') }}
        </div>
        @endif

        <div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px;">
            <div>
                <h1 style="font-family: var(--font-heading); font-size: 36px; font-weight: 700; color: var(--text); margin-bottom: 8px; letter-spacing: 0.05em;">ORDER <span style="color: var(--text-secondary);">#{{ substr($order->order_id, 6) }}</span></h1>
                <p style="color: var(--text-secondary); font-family: var(--font); font-size: 14px; text-transform: uppercase; letter-spacing: 0.05em;">Placed on {{ $order->created_at->setTimezone('Asia/Kolkata')->format('d M Y, h:i A') }}</p>
            </div>
            
            <div style="display: flex; gap: 16px; align-items: center;">
                @if($order->status === 'pending' || $order->status === 'paid')
                <form action="{{ route('orders.cancel', $order->order_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                    @csrf
                    <button type="submit" style="background: transparent; border: 1px solid #dc3545; color: #dc3545; padding: 12px 24px; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.1em; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#dc3545'; this.style.color='#fff';" onmouseout="this.style.background='transparent'; this.style.color='#dc3545';">
                        CANCEL ORDER
                    </button>
                </form>
                @endif

                @if($order->status === 'delivered')
                <form action="{{ route('orders.return', $order->order_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to request a return for this order?');">
                    @csrf
                    <button type="submit" style="background: transparent; border: 1px solid var(--text); color: var(--text); padding: 12px 24px; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.1em; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='var(--text)'; this.style.color='#fff';" onmouseout="this.style.background='transparent'; this.style.color='var(--text)';">
                        REQUEST RETURN
                    </button>
                </form>
                @endif

                <a href="{{ route('orders.invoice', $order->order_id) }}" class="gr-hero-btn-primary" style="background: var(--text); font-size: 12px; padding: 12px 24px;">
                    <i class="fas fa-file-pdf" style="margin-right: 8px;"></i> INVOICE
                </a>
            </div>
        </div>

        {{-- Tracking Timeline --}}
        <div style="background: var(--surface); border: 1px solid var(--border); padding: 40px; margin-bottom: 32px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;">
                <h2 style="font-family: var(--font-heading); font-size: 24px;">STATUS TRACKER</h2>
                @if($order->tracking_number)
                    <div style="font-family: var(--font); font-size: 12px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary);">
                        TRACKING: <span style="font-weight: 700; color: var(--text); font-family: monospace; font-size: 14px;">{{ $order->tracking_number }}</span>
                    </div>
                @endif
            </div>

            @php
                $statuses = ['pending', 'paid', 'shipped', 'delivered'];
                $currentIndex = array_search($order->status, $statuses);
                if ($currentIndex === false) $currentIndex = -1; 
            @endphp

            @if($order->status === 'cancelled')
                <div style="background: rgba(220,53,69,0.05); border: 1px dashed #dc3545; color: #dc3545; padding: 24px; text-align: center; font-family: var(--font-heading); font-size: 20px; letter-spacing: 0.1em;">
                    THIS ORDER HAS BEEN CANCELLED.
                </div>
            @elseif($order->status === 'cancel_requested')
                <div style="background: rgba(255,193,7,0.05); border: 1px dashed #ffc107; color: #b58000; padding: 24px; text-align: center; font-family: var(--font-heading); font-size: 20px; letter-spacing: 0.1em;">
                    CANCELLATION REQUESTED AND PENDING APPROVAL.
                </div>
            @elseif($order->status === 'return_requested')
                <div style="background: rgba(255,193,7,0.05); border: 1px dashed #ffc107; color: #b58000; padding: 24px; text-align: center; font-family: var(--font-heading); font-size: 20px; letter-spacing: 0.1em;">
                    RETURN REQUESTED AND PENDING APPROVAL.
                </div>
            @elseif($order->status === 'returned')
                <div style="background: rgba(40,167,69,0.05); border: 1px dashed #28a745; color: #28a745; padding: 24px; text-align: center; font-family: var(--font-heading); font-size: 20px; letter-spacing: 0.1em;">
                    THIS ORDER HAS BEEN RETURNED & REFUNDED.
                </div>
            @else
                <div style="display: flex; justify-content: space-between; position: relative; margin-top: 20px;">
                    <!-- Line -->
                    <div style="position: absolute; top: 15px; left: 0; width: 100%; height: 2px; background: var(--border); z-index: 0;"></div>
                    <div style="position: absolute; top: 15px; left: 0; height: 2px; background: var(--text); z-index: 0; transition: width 1s ease-in-out; width: {{ $currentIndex >= 0 ? ($currentIndex / (count($statuses) - 1)) * 100 : 0 }}%;"></div>

                    @foreach($statuses as $index => $statusText)
                        @php 
                            $isCompleted = $index <= $currentIndex;
                            $isCurrent = $index === $currentIndex;
                        @endphp
                        <div style="display: flex; flex-direction: column; align-items: center; position: relative; z-index: 1;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold; background: {{ $isCompleted ? 'var(--text)' : 'var(--surface)' }}; color: {{ $isCompleted ? 'var(--surface)' : 'var(--text-secondary)' }}; border: 2px solid {{ $isCompleted ? 'var(--text)' : 'var(--border)' }}; margin-bottom: 12px; transition: all 0.3s;">
                                @if($isCompleted) <i class="fas fa-check"></i> @else {{ $index + 1 }} @endif
                            </div>
                            <span style="font-size: 11px; font-weight: {{ $isCurrent ? '700' : '600' }}; color: {{ $isCurrent ? 'var(--text)' : 'var(--text-secondary)' }}; text-transform: uppercase; letter-spacing: 0.1em;">{{ $statusText }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;" class="order-grid">
            
            {{-- Items --}}
            <div style="background: var(--surface); border: 1px solid var(--border); padding: 40px;">
                <h2 style="font-family: var(--font-heading); font-size: 24px; margin-bottom: 32px; padding-bottom: 16px; border-bottom: 1px solid var(--border);">MANIFEST</h2>
                
                <div style="display: flex; flex-direction: column; gap: 32px;">
                    @foreach ($order->items as $item)
                    @php $product = $item->product; @endphp
                    <div style="display: flex; gap: 24px; align-items: center;">
                        @if($product)
                        <a href="{{ route('product.view', $product->id) }}" style="width: 100px; height: 130px; background: var(--bg); flex-shrink: 0; display: block;">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $item->product_name }}" style="width: 100%; height: 100%; object-fit: cover; mix-blend-mode: multiply;">
                        </a>
                        @else
                        <div style="width: 100px; height: 130px; background: var(--bg); display: flex; align-items: center; justify-content: center; color: var(--border); flex-shrink: 0;">
                            <i class="fas fa-image" style="font-size: 24px;"></i>
                        </div>
                        @endif
                        
                        <div style="flex: 1;">
                            <h3 style="font-family: var(--font-heading); font-size: 18px; margin-bottom: 8px;">
                                @if($product)
                                    <a href="{{ route('product.view', $product->id) }}" style="color: var(--text); text-decoration: none;">{{ $item->product_name }}</a>
                                @else
                                    {{ $item->product_name }}
                                @endif
                            </h3>
                            <div style="font-family: var(--font); font-size: 12px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em; display: flex; flex-direction: column; gap: 4px;">
                                <span>SIZE: <strong style="color: var(--text);">{{ $item->size }}</strong></span>
                                <span>QTY: <strong style="color: var(--text);">{{ $item->quantity }}</strong></span>
                            </div>
                        </div>
                        
                        <div style="font-family: var(--font); font-weight: 700; font-size: 16px; color: var(--text);">
                            ₹{{ number_format($item->price * $item->quantity, 2) }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Summary Sidebar --}}
            <div style="display: flex; flex-direction: column; gap: 32px;">
                
                <div style="background: var(--surface); border: 1px solid var(--border); padding: 40px;">
                    <h2 style="font-family: var(--font-heading); font-size: 24px; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border);">SUMMARY</h2>
                    
                    @php
                        $shipping = $order->shipping_fee ?? 0.00;
                        $discount = $order->discount_amount ?? 0.00;
                        $subtotal = $order->total_amount - $shipping + $discount;
                    @endphp
                    <div style="display: flex; flex-direction: column; gap: 16px; margin-bottom: 32px; font-family: var(--font); font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em;">
                        <div style="display: flex; justify-content: space-between; color: var(--text-secondary);">
                            <span>Subtotal</span>
                            <span style="font-weight: 600; color: var(--text);">₹{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; color: var(--text-secondary);">
                            <span>Shipping</span>
                            <span style="font-weight: 600; color: var(--text);">{{ $shipping > 0 ? '₹' . number_format($shipping, 2) : 'Free' }}</span>
                        </div>
                        @if($discount > 0)
                        <div style="display: flex; justify-content: space-between; color: var(--accent);">
                            <span>Discount ({{ $order->coupon_code }})</span>
                            <span style="font-weight: 600;">-₹{{ number_format($discount, 2) }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 24px; border-top: 1px solid var(--text);">
                        <span style="font-family: var(--font-heading); font-size: 18px;">TOTAL</span>
                        <span style="font-family: var(--font); font-weight: 700; font-size: 24px; color: var(--text);">₹{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>

                <div style="background: var(--bg); border: 1px solid var(--border); padding: 40px;">
                    <h2 style="font-family: var(--font-heading); font-size: 18px; margin-bottom: 20px;">SHIPPING DETAILS</h2>
                    <div style="font-family: var(--font); font-size: 13px; color: var(--text-secondary); line-height: 1.6;">
                        <span style="display: block; font-weight: 700; color: var(--text); margin-bottom: 8px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.05em;">{{ $order->name }}</span>
                        <span style="display: block;">{{ $order->address }}</span>
                        <span style="display: block;">{{ $order->city }}, {{ $order->state }}</span>
                        <span style="display: block; margin-bottom: 12px;">{{ $order->zip }}</span>
                        <span style="display: block; padding-top: 12px; border-top: 1px solid var(--border);">PHONE: {{ $order->phone }}</span>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<style>
@media (max-width: 900px) {
    .order-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>

@endsection