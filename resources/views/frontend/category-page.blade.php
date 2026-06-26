@extends('layouts.front')
@section('title', $category->name . ' | GET READY')

@section('content')

{{-- ─── CATEGORY HERO ───────────────────────────────────────── --}}
<section class="gr-hero" style="min-height: 300px; padding: 40px 24px;">
    <div class="gr-hero-text" style="padding-top: 0;">
        <div class="gr-hero-label">CATEGORY</div>
        <h1 class="gr-hero-heading" style="font-size: clamp(36px, 5vw, 64px); margin-bottom: 12px;">
            {{ strtoupper($category->name) }}
        </h1>
        <p class="gr-hero-subtitle" style="margin-bottom: 0;">
            Heavyweight and honest. Explore the {{ strtolower($category->name) }} collection.
        </p>
    </div>
    <div class="gr-hero-images" style="min-height: 250px;">
        <div class="gr-hero-img-1" style="width: 100%; height: 100%; top: 0;">
            <img src="{{ get_storage_url($category->image) }}" 
                 alt="{{ $category->name }}" loading="eager">
        </div>
    </div>
</section>

<div class="o-breadcrumb">
    <div class="o-breadcrumb-inner">
        <a href="{{ url('/') }}">Home</a> <span class="sep">/</span> 
        <a href="{{ route('products.all') }}">Shop</a> <span class="sep">/</span>
        <span class="current">{{ $category->name }}</span>
    </div>
</div>

<div class="o-shop">
    {{-- Sidebar Filters --}}
    <aside class="o-sidebar" aria-labelledby="filterHeading">
        <h2 id="filterHeading" class="o-sidebar-title"><i class="fas fa-sliders-h" aria-hidden="true"></i> Filters</h2>
        
        <form action="{{ route('category.show', $category->slug) }}" method="GET">
            <div class="o-form-group">
                <label for="search" class="o-label">Search</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" class="o-input" placeholder="Find products...">
            </div>
            

            
            <div class="o-form-group">
                <label for="sort" class="o-label">Sort By</label>
                <div class="o-select-wrap">
                    <select id="sort" name="sort" class="o-input">
                        <option value="">Default Sorting</option>
                        <option value="new"  {{ request('sort') == 'new'  ? 'selected' : '' }}>Newest First</option>
                        <option value="low"  {{ request('sort') == 'low'  ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="high" {{ request('sort') == 'high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>
            </div>
            
            <button type="submit" class="o-btn o-btn-primary o-btn-full" style="margin-top:10px;">Apply Filters</button>
            
            @if(request()->hasAny(['search','sort']))
            <a href="{{ route('category.show', $category->slug) }}" class="o-btn o-btn-ghost o-btn-full" style="margin-top:10px; font-size:13px; color:var(--text-secondary);">Clear All</a>
            @endif
        </form>
    </aside>

    {{-- Product Grid --}}
    <div>
        <div class="o-shop-main-top">
            <h1>{{ $category->name }}</h1>
            <span class="o-item-count">{{ $products->total() }} items</span>
        </div>

        @php
        $phs = [
            asset('assets/images/logo.png'),
            asset('assets/images/logo.png'),
            asset('assets/images/logo.png'),
            asset('assets/images/logo.png'),
        ];
        @endphp

        @if($products->count() > 0)
        <div class="o-product-grid o-product-grid-3">
            @foreach($products as $i => $product)
            <a href="{{ route('product.view', $product->id) }}" class="o-product-card" aria-label="View {{ $product->name }}">
                <div class="o-product-card-img">
                    @auth
                        @php
                            $inWishlist = auth()->user()->wishlistItems->contains('product_id', $product->id);
                        @endphp
                        <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" style="position: absolute; top: 10px; right: 10px; z-index: 5; margin: 0;">
                            @csrf
                            <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();" class="o-product-wishlist" aria-label="Toggle Wishlist">
                                <i class="{{ $inWishlist ? 'fas' : 'far' }} fa-heart" aria-hidden="true" style="color: {{ $inWishlist ? 'var(--accent)' : 'inherit' }};"></i>
                            </button>
                        </form>
                    @endauth
                    @php
                        $validImages = array_filter([$product->image, $product->image_2, $product->image_3, $product->image_4]);
                        $imageUrls = array_map(function ($img) {
                            return get_storage_url($img);
                        }, array_values($validImages));
                    @endphp
                    <img src="{{ get_storage_url($product->image) }}" 
                         data-images='@json($imageUrls)' class="hover-slideshow"
                         onerror="this.src='{{ $phs[$i % 4] }}'" 
                         alt="{{ $product->name }}" loading="lazy">
                </div>
                <div class="o-product-card-body">
                    <span class="o-product-cat">{{ $category->name }}</span>
                    <h3 class="o-product-name">{{ $product->name }}</h3>
                    <div class="o-product-price">
                        <span class="from">₹</span>{{ number_format($product->sizes->min('price') ?? $product->price ?? 0, 2) }}
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        
        <div style="margin-top: 40px; display: flex; justify-content: center;">
            {{ $products->appends(request()->query())->links() }}
        </div>
        
        @else
        <div class="o-empty-state">
            <i class="fas fa-box-open" aria-hidden="true" style="font-size: 40px; color: var(--border); margin-bottom: 16px;"></i>
            <h3>No products found</h3>
            <p>We couldn't find any products in this category matching your filters.</p>
            <a href="{{ route('category.show', $category->slug) }}" class="o-btn o-btn-primary" style="margin-top: 20px;">Clear Filters</a>
        </div>
        @endif
    </div>
</div>

@endsection