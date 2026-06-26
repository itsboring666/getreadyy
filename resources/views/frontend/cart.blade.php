@extends('layouts.front')
@section('title', 'Shopping Cart | GET READY')

@section('content')

<div class="o-breadcrumb">
    <div class="o-breadcrumb-inner">
        <a href="{{ url('/') }}">Home</a> <span class="sep">/</span> <span class="current">Shopping Cart</span>
    </div>
</div>

<div class="o-cart-layout">
    <div style="grid-column: 1 / -1;">
        <h1 style="font-family:var(--font-heading); font-size:28px; font-weight:700; color:var(--text); margin-bottom:8px;">Your Shopping Cart</h1>
        <p style="color:var(--text-secondary); margin-bottom:24px;">{{ $items->count() }} items in your bag</p>
    </div>

    @if($items->count() > 0)
    <div class="o-cart-table">
        <table>
            <thead>
                <tr>
                    <th scope="col">Product Details</th>
                    <th scope="col" style="text-align:center;">Quantity</th>
                    <th scope="col" style="text-align:right;">Price</th>
                    <th scope="col" style="text-align:right;">Total</th>
                    <th scope="col" style="text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody>
                @php $subtotal = 0; @endphp
                @foreach($items as $item)
                @php
                    $product = $item->product;
                    $price = $item->unit_price ?? 0;
                    $total = $price * $item->quantity;
                    $subtotal += $total;
                @endphp
                <tr>
                    <td>
                        <div class="o-cart-product-info">
                            <img src="{{ get_storage_url($product->image) }}" alt="{{ $product->name }}">
                            <div>
                                <a href="{{ route('product.view', $product->id) }}" class="o-cart-product-name">{{ $product->name }}</a>
                                <div class="o-cart-product-meta">Size: <strong>{{ $item->size }}</strong></div>
                                <div class="o-cart-product-meta">Item #: {{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="text-align:center;">
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display:flex; align-items:center; justify-content:center; gap:8px;">
                            @csrf
                            @method('PUT')
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" style="width:60px; padding:6px; border:1px solid var(--border); border-radius:var(--radius); text-align:center;">
                            <button type="submit" class="o-btn o-btn-primary" style="padding:6px 12px; font-size:12px;">Update</button>
                        </form>
                    </td>
                    <td style="text-align:right; font-weight:500;">
                        ₹{{ number_format($price, 2) }}
                    </td>
                    <td style="text-align:right; font-weight:600; color:var(--text);">
                        ₹{{ number_format($total, 2) }}
                    </td>
                    <td style="text-align:center;">
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Remove this item from your cart?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="o-cart-remove" aria-label="Remove {{ $product->name }} from cart">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Order Summary --}}
    <aside class="o-order-summary">
        <h3>Order Summary</h3>
        
        <div class="o-summary-row">
            <span>Subtotal</span>
            <span style="font-weight:600;">₹{{ number_format($subtotal, 2) }}</span>
        </div>
        
        @php
            $shipping_fee = \App\Models\Setting::get('shipping_fee', 99.00);
            $free_shipping_threshold = \App\Models\Setting::get('free_shipping_threshold', 999.00);
            $shipping = $subtotal >= $free_shipping_threshold ? 0.00 : (float)$shipping_fee;
            $grandTotal = $subtotal + $shipping;
        @endphp

        <div class="o-summary-row">
            <span>Shipping</span>
            <span>{{ $shipping > 0 ? '₹' . number_format($shipping, 2) : 'Free' }}</span>
        </div>
        
        <div class="o-summary-row">
            <span>Taxes</span>
            <span>Included</span>
        </div>
        
        <div class="o-summary-divider"></div>
        
        <div class="o-summary-row total">
            <span>Estimated Total</span>
            <span style="color:var(--accent);">₹{{ number_format($grandTotal, 2) }}</span>
        </div>
        
        <div style="margin-top:24px;">
            <a href="{{ route('checkout') }}" class="o-btn o-btn-primary o-btn-full o-btn-lg" style="margin-bottom:12px;">Proceed to Checkout</a>
            <a href="{{ route('products.all') }}" class="o-btn o-btn-outline o-btn-full o-btn-lg" style="color:var(--primary); border-color:var(--border);">Continue Shopping</a>
        </div>
        
        <div style="margin-top:20px; text-align:center; font-size:12px; color:var(--text-secondary);">
            <i class="fas fa-lock" aria-hidden="true" style="margin-right:4px;"></i> Secure Checkout Guaranteed
        </div>
    </aside>

    @else
    <div class="o-empty" style="grid-column: 1 / -1; background:#161616; border:1px solid var(--border); border-radius:var(--radius-lg);">
        <i class="fas fa-shopping-bag o-empty-icon" aria-hidden="true"></i>
        <h3>Your cart is empty</h3>
        <p>Looks like you haven't added anything to your cart yet.</p>
        <a href="{{ route('products.all') }}" class="o-btn o-btn-primary" style="margin-top:16px;">Start Shopping</a>
    </div>
    @endif
</div>

@endsection