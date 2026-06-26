@extends('layouts.front')
@section('title', 'All Products | GET READY')

@section('content')
<div class="o-breadcrumb">
    <div class="o-breadcrumb-inner">
        <a href="{{ url('/') }}">Home</a> <span class="sep">/</span> <span class="current">Shop</span>
    </div>
</div>

<div class="o-shop">
    {{-- Sidebar Filters --}}
    <aside class="o-sidebar" aria-labelledby="filterHeading">
        <h2 id="filterHeading" class="o-sidebar-title"><i class="fas fa-sliders-h" aria-hidden="true"></i> Filters</h2>
        
        <form action="{{ route('products.all') }}" method="GET">
            <div class="o-form-group">
                <label for="search" class="o-label">Search</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" class="o-input" placeholder="Find products...">
            </div>
            
            <div class="o-form-group">
                <label for="category" class="o-label">Category</label>
                <div class="o-select-wrap">
                    <select id="category" name="category" class="o-input">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
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
            
            @if(request()->hasAny(['search','category','sort']))
            <a href="{{ route('products.all') }}" class="o-btn o-btn-ghost o-btn-full" style="margin-top:10px; font-size:13px; color:var(--text-secondary);">Clear All</a>
            @endif
        </form>
    </aside>

    {{-- Product Grid --}}
    <div>
        <div class="o-shop-main-top">
            <h1>All Products</h1>
            <span class="o-item-count">{{ $products->total() }} items</span>
        </div>

        @php
        $phs = [
            asset('assets/images/logo.png'),
            asset('assets/images/logo.png'),
            asset('assets/images/logo.png'),
            asset('assets/images/logo.png'),
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
                            return asset('storage/' . $img);
                        }, array_values($validImages));
                    @endphp
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         data-images='@json($imageUrls)' class="hover-slideshow"
                         onerror="this.src='{{ $phs[$i % 8] }}'" 
                         alt="{{ $product->name }}" loading="lazy">
                </div>
                <div class="o-product-card-body">
                    <span class="o-product-cat">{{ $product->category->name ?? 'Category' }}</span>
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
        <div class="o-empty">
            <i class="fas fa-search o-empty-icon" aria-hidden="true"></i>
            <h3>No products found</h3>
            <p>Try adjusting your filters or search query.</p>
            <a href="{{ route('products.all') }}" class="o-btn o-btn-primary">Clear Filters</a>
        </div>
        @endif
    </div>
</div>
@endsection