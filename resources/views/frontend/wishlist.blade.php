@extends('layouts.front')
@section('title', 'My Wishlist | GET READY')

@section('content')

<div class="o-breadcrumb">
    <div class="o-breadcrumb-inner">
        <a href="{{ url('/') }}">Home</a> <span class="sep">/</span> <span class="current">Wishlist</span>
    </div>
</div>

<div class="gr-wardrobe" style="padding: 40px 24px 80px;">
    <div style="max-width: var(--max-width); margin: 0 auto;">
        <h1 style="font-family: var(--font-heading); font-size: 32px; color: var(--text); margin-bottom: 8px;">My Wishlist</h1>
        <p style="color: var(--text-secondary); margin-bottom: 40px;">{{ $wishlistItems->count() }} {{ $wishlistItems->count() === 1 ? 'item' : 'items' }} saved in your list</p>


        @if($wishlistItems->count() > 0)
        <div class="gr-product-grid gr-product-grid-3">
            @foreach($wishlistItems as $item)
            @php $product = $item->product; @endphp
            @if($product)
            <div class="gr-product-card" style="background: #161616; padding: 12px; position: relative;">
                {{-- Toggle wishlist button --}}
                <div style="position: absolute; top: 20px; right: 20px; z-index: 10;">
                    <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" style="background: #1a1a1a; border: 1px solid var(--border); border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--primary); transition: all 0.2s;">
                            <i class="fas fa-heart" aria-hidden="true" style="font-size: 16px;"></i>
                        </button>
                    </form>
                </div>

                <a href="{{ route('product.view', $product->id) }}" style="text-decoration: none;">
                    <div class="gr-product-card-img" style="aspect-ratio: 3/4;">
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             onerror="this.src='{{ asset('assets/images/logo.png') }}'" 
                             alt="{{ $product->name }}" loading="lazy" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <div class="gr-product-card-body" style="padding: 16px 8px 8px;">
                        <div class="gr-product-name" style="font-size: 15px; font-weight: 600; color: var(--text);">{{ $product->name }}</div>
                        <div class="gr-product-meta" style="margin-top: 8px;">
                            <span class="gr-product-cat">{{ $product->category->name ?? 'GET READY' }}</span>
                            <span class="gr-product-price" style="font-weight: bold; color: var(--text);">₹{{ number_format($product->sizes->min('price') ?? $product->price ?? 0, 2) }}</span>
                        </div>
                    </div>
                </a>
            </div>
            @endif
            @endforeach
        </div>
        @else
        <div style="text-align: center; padding: 80px 20px; background: #161616; border: 1px solid var(--border);">
            <i class="far fa-heart" style="font-size: 48px; color: var(--text-muted); margin-bottom: 16px; display: block;"></i>
            <h3 style="font-family: var(--font-heading); font-size: 24px; margin-bottom: 8px;">Your wishlist is empty</h3>
            <p style="color: var(--text-secondary); font-family: var(--font); margin-bottom: 24px;">Add your favorite pieces here to save them for later.</p>
            <a href="{{ route('products.all') }}" class="o-btn o-btn-primary">Go Shopping</a>
        </div>
        @endif
    </div>
</div>

@endsection
