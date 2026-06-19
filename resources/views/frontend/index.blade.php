@extends('layouts.front')
@section('title', 'GET READY — Premium Menswear')
@section('meta_description', 'Shop premium menswear at GET READY. Heavy fabrics. Honest stitching. Men\'s clothing store.')

@section('content')
<style>
/* Wishlist heart display on hover */
.gr-product-card:hover .o-product-wishlist { opacity: 1; }

/* Hero section neat block layout */
.gr-hero {
    border: 2px solid var(--border) !important;
    background: var(--surface) !important;
    box-shadow: 6px 6px 0px var(--primary) !important;
    margin: 40px auto !important;
    padding: 48px !important;
    box-sizing: border-box !important;
}

/* ─── Premium Home Page Animations & Styling ─── */

/* 1. Hero Text Reveal Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(24px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.gr-hero-text > * {
    animation: fadeInUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    opacity: 0;
}
.gr-hero-text > .gr-hero-label { animation-delay: 0.1s; }
.gr-hero-text > .gr-hero-heading { animation-delay: 0.3s; }
.gr-hero-text > .gr-hero-subtitle { animation-delay: 0.5s; }
.gr-hero-text > .gr-hero-btns { animation-delay: 0.7s; }

/* 2. Floating Image Effect for Hero Images */
@keyframes floatImage1 {
    0%, 100% { transform: translateY(0px) rotate(-1deg); }
    50% { transform: translateY(-8px) rotate(0.5deg); }
}
@keyframes floatImage2 {
    0%, 100% { transform: translateY(0px) rotate(1deg); }
    50% { transform: translateY(-10px) rotate(-0.5deg); }
}
.gr-hero-img-1 {
    animation: floatImage1 7s ease-in-out infinite;
}
.gr-hero-img-2 {
    animation: floatImage2 7s ease-in-out infinite;
    animation-delay: 3.5s;
}

/* 3. Hero Circle Badge Spin Animation */
@keyframes spinBadge {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
.gr-hero-circle-badge {
    animation: spinBadge 16s linear infinite;
    transition: transform var(--transition);
}
.gr-hero-circle-badge:hover {
    animation-play-state: paused;
    transform: scale(1.15);
}

/* 6. Wardrobe Grid neat catalog borders and offset shadows */
.gr-wardrobe-card {
    border: 1px solid var(--border) !important;
    box-shadow: 3px 3px 0px rgba(153,27,27,0.4) !important;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
    background: var(--surface) !important;
}
.gr-wardrobe-card:hover {
    transform: translate(-3px, -3px) !important;
    box-shadow: 7px 7px 0px var(--primary) !important;
}
.gr-wardrobe-card img {
    transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
.gr-wardrobe-card:hover img {
    transform: scale(1.03) !important;
}
.gr-wardrobe-title {
    font-family: var(--font-heading) !important;
    font-size: clamp(20px, 2.5vw, 32px) !important;
    color: var(--white) !important;
    background: rgba(0,0,0,0.7) !important;
    display: inline-block !important;
    padding: 4px 12px !important;
    margin-bottom: 8px !important;
    border: 1px solid rgba(255,255,255,0.15) !important;
}
.gr-wardrobe-link {
    font-family: var(--font) !important;
    font-size: 8px !important;
    font-weight: 700 !important;
    letter-spacing: 0.1em !important;
    color: var(--white) !important;
    background: var(--primary) !important;
    padding: 4px 8px !important;
    border: none !important;
    display: inline-block !important;
}
.gr-wardrobe-overlay {
    transition: background 0.3s ease;
}
.gr-wardrobe-card:hover .gr-wardrobe-overlay {
    background: rgba(26, 26, 26, 0.4);
}
.gr-wardrobe-link {
    transition: transform 0.3s ease, letter-spacing 0.3s ease;
    display: inline-block;
}
.gr-wardrobe-card:hover .gr-wardrobe-link {
    transform: translateX(6px);
    letter-spacing: 0.08em;
}

/* 5. Product Cards Polaroid styling */
.gr-product-card {
    border: 1px solid var(--border) !important;
    padding: 10px 10px 18px 10px !important;
    box-shadow: 4px 4px 0px rgba(153,27,27,0.35) !important;
    background: var(--surface) !important;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
.gr-product-card:hover {
    transform: translateY(-4px) !important;
    box-shadow: 7px 7px 0px rgba(153,27,27,0.5) !important;
    border-color: var(--primary) !important;
}
.gr-product-card-img {
    overflow: hidden;
    position: relative;
    aspect-ratio: 1/1 !important;
    border: 2px solid var(--primary) !important;
}
.gr-product-card-img img {
    transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}
.gr-product-card:hover .gr-product-card-img img {
    transform: scale(1.04);
}
.gr-product-view-btn {
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    opacity: 0;
    transform: translate(-50%, -30%);
}
.gr-product-card:hover .gr-product-view-btn {
    opacity: 1;
    transform: translate(-50%, -50%);
    background: var(--primary);
    color: var(--white);
}

/* 6. Editorial Float Animations */
@keyframes floatEditorial1 {
    0%, 100% { transform: translateY(0px) scale(1); }
    50% { transform: translateY(-6px) scale(1.01); }
}
@keyframes floatEditorial2 {
    0%, 100% { transform: translateY(0px) scale(1); }
    50% { transform: translateY(-8px) scale(0.99); }
}
.gr-editorial-img-1 {
    animation: floatEditorial1 8s ease-in-out infinite;
}
.gr-editorial-img-2 {
    animation: floatEditorial2 8s ease-in-out infinite;
    animation-delay: 4s;
}

/* 7. Hover effects on trust card icons */
.gr-trust-card {
    transition: transform var(--transition), border-color var(--transition);
}
.gr-trust-card:hover {
    transform: translateY(-4px);
    border-color: var(--border) !important;
}
.gr-trust-card i {
    transition: transform 0.4s ease;
}
.gr-trust-card:hover i {
    transform: scale(1.2) rotate(5deg);
}

/* 8. Interactive button highlights */
.gr-hero-btn-primary, .gr-hero-btn-outline, .gr-editorial-btn, .gr-cta-btn {
    position: relative;
    overflow: hidden;
    z-index: 1;
    transition: all 0.3s ease;
}
.gr-hero-btn-primary:hover, .gr-editorial-btn:hover, .gr-cta-btn:hover {
    box-shadow: 0 8px 16px rgba(26,26,26,0.15);
}

/* 9. Mobile Responsive Fixes */
.gr-cta-upgraded {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 48px;
    align-items: center;
}

@media (max-width: 768px) {
    .gr-hero {
        padding: 24px 16px !important;
        margin: 20px 10px !important;
        box-shadow: 4px 4px 0px var(--primary) !important;
    }
    .gr-cta-upgraded {
        grid-template-columns: 1fr;
        padding: 32px 20px !important;
        gap: 32px;
        text-align: center;
    }
    .gr-cta-upgraded h2 {
        font-size: clamp(28px, 6vw, 36px) !important;
    }
    .gr-hero-heading {
        font-size: clamp(36px, 10vw, 50px) !important;
        margin-bottom: 20px;
    }
    .gr-hero-images {
        min-height: 400px;
        margin-top: 24px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .gr-hero-img-1, .gr-hero-img-2 {
        position: relative !important;
        width: 100% !important;
        height: auto !important;
        left: 0 !important;
        right: 0 !important;
        top: 0 !important;
        bottom: 0 !important;
        transform: none !important;
        animation: none !important;
        box-shadow: 4px 4px 0px rgba(0,0,0,0.2) !important;
    }
    .gr-hero-circle-badge {
        display: none !important; /* Hide badge on mobile to avoid clutter */
    }
}
</style>

{{-- ─── LANDING HERO ───────────────────────────────────────── --}}
@php
$heroImg1 = asset('assets/images/hero1.jpg');
$heroImg2 = asset('assets/images/hero2.jpg');
@endphp

<section class="gr-hero">
    {{-- Giant outlined background text removed as per request --}}

    <div class="gr-hero-text">
        <div class="gr-hero-label">FALL / WINTER '26 — VOL. III</div>
        <h1 class="gr-hero-heading" style="text-transform: uppercase;">
            MEN'S<br>
            CLOTHING<br>
            <em>store</em>
        </h1>
        <p class="gr-hero-subtitle">
            Premium menswear. Made for the road.
        </p>
        <div class="gr-hero-btns">
            <a href="{{ route('products.all') }}" class="gr-hero-btn-primary">SHOP THE DROP →</a>
            <a href="{{ route('outfit-builder') }}" class="gr-hero-btn-outline">OUTFIT BUILDER</a>
        </div>
        
        {{-- Vintage Barcode stamp removed as per request --}}
    </div>
    <div class="gr-hero-images">
        {{-- Hero tag removed --}}
        <div class="gr-hero-img-1">
            <img src="{{ $heroImg1 }}" 
                 alt="Lifestyle editorial" loading="eager">
        </div>
        <div class="gr-hero-img-2">
            <img src="{{ $heroImg2 }}" 
                 alt="Street style fashion" loading="eager">
        </div>
        <div class="gr-hero-circle-badge">
            <span>NEW DROP<br>•<br>LIMITED<br>STOCK</span>
        </div>
    </div>
</section>

{{-- ─── MARQUEE TICKER ─────────────────────────────────────── --}}
<div class="gr-marquee">
    <div class="gr-marquee-track">
        <div class="gr-marquee-content">
            <span class="gr-marquee-item">Street wear</span>
            <span class="gr-marquee-dot">✦</span>
            <span class="gr-marquee-item">vintage style</span>
            <span class="gr-marquee-dot">✦</span>
            <span class="gr-marquee-item">casuals</span>
            <span class="gr-marquee-dot">✦</span>
            <span class="gr-marquee-item">formulas</span>
            <span class="gr-marquee-dot">✦</span>
            <span class="gr-marquee-item">Street wear</span>
            <span class="gr-marquee-dot">✦</span>
            <span class="gr-marquee-item">vintage style</span>
            <span class="gr-marquee-dot">✦</span>
            <span class="gr-marquee-item">casuals</span>
            <span class="gr-marquee-dot">✦</span>
            <span class="gr-marquee-item">formulas</span>
            <span class="gr-marquee-dot">✦</span>
        </div>
        {{-- Duplicate for seamless loop --}}
        <div class="gr-marquee-content">
            <span class="gr-marquee-item">Street wear</span>
            <span class="gr-marquee-dot">✦</span>
            <span class="gr-marquee-item">vintage style</span>
            <span class="gr-marquee-dot">✦</span>
            <span class="gr-marquee-item">casuals</span>
            <span class="gr-marquee-dot">✦</span>
            <span class="gr-marquee-item">formulas</span>
            <span class="gr-marquee-dot">✦</span>
            <span class="gr-marquee-item">Street wear</span>
            <span class="gr-marquee-dot">✦</span>
            <span class="gr-marquee-item">vintage style</span>
            <span class="gr-marquee-dot">✦</span>
            <span class="gr-marquee-item">casuals</span>
            <span class="gr-marquee-dot">✦</span>
            <span class="gr-marquee-item">formulas</span>
            <span class="gr-marquee-dot">✦</span>
        </div>
    </div>
</div>

{{-- ─── THE WARDROBE (Category Grid) ──────────────────────── --}}
@php
$wardrobeImgs = [
    'https://images.unsplash.com/photo-1622445275576-721325763afe?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1542272604-787c3835535d?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1551028719-00167b16eac5?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1572635196237-14b3f281503f?auto=format&fit=crop&w=600&q=80',
];
$wardrobeNames = ['TEES', 'JEANS', 'SHIRTS', 'JACKETS', 'ACCESSORIES'];
@endphp

<div class="gr-section-header">
    <div class="gr-section-header-inner">
        <div>
            <div class="gr-section-label">INDEX — 01</div>
            <h2 class="gr-section-title">THE WARDROBE</h2>
        </div>
        <a href="{{ route('products.all') }}" class="gr-section-link">VIEW ALL →</a>
    </div>
</div>

<div class="gr-wardrobe">
    <div class="gr-wardrobe-grid">
        {{-- Tall card (left, spans 2 rows) --}}
        @if($categories->count() > 0)
        <a href="{{ url($categories->first()->slug) }}" class="gr-wardrobe-card gr-wardrobe-card-tall" aria-label="Shop {{ $categories->first()->name }}">
            <img src="{{ asset('storage/' . $categories->first()->image) }}" 
                 onerror="this.src='{{ $wardrobeImgs[0] }}'"
                 alt="{{ $categories->first()->name }}" loading="lazy">
            <div class="gr-wardrobe-overlay">
                <div class="gr-wardrobe-title">{{ strtoupper($categories->first()->name) }}</div>
                <span class="gr-wardrobe-link">SHOP {{ strtoupper($categories->first()->name) }} →</span>
            </div>
        </a>
        @endif

        {{-- Top-right 2 cards --}}
        @foreach($categories->skip(1)->take(2) as $i => $cat)
        <a href="{{ url($cat->slug) }}" class="gr-wardrobe-card gr-wardrobe-card-normal" aria-label="Shop {{ $cat->name }}">
            <img src="{{ asset('storage/' . $cat->image) }}" 
                 onerror="this.src='{{ $wardrobeImgs[($i + 1) % 5] }}'"
                 alt="{{ $cat->name }}" loading="lazy">
            <div class="gr-wardrobe-overlay">
                <div class="gr-wardrobe-title">{{ strtoupper($cat->name) }}</div>
                <span class="gr-wardrobe-link">SHOP {{ strtoupper($cat->name) }} →</span>
            </div>
        </a>
        @endforeach

        {{-- Bottom-right 2 cards --}}
        @foreach($categories->skip(3)->take(2) as $i => $cat)
        <a href="{{ url($cat->slug) }}" class="gr-wardrobe-card gr-wardrobe-card-normal" aria-label="Shop {{ $cat->name }}">
            <img src="{{ asset('storage/' . $cat->image) }}" 
                 onerror="this.src='{{ $wardrobeImgs[($i + 3) % 5] }}'"
                 alt="{{ $cat->name }}" loading="lazy">
            <div class="gr-wardrobe-overlay">
                <div class="gr-wardrobe-title">{{ strtoupper($cat->name) }}</div>
                <span class="gr-wardrobe-link">SHOP {{ strtoupper($cat->name) }} →</span>
            </div>
        </a>
        @endforeach
    </div>
</div>

{{-- ─── FRESH OFF THE PRESS ────────────────────────────────── --}}
@php
$phs = [
    'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?auto=format&fit=crop&w=500&q=80',
    'https://images.unsplash.com/photo-1576566588028-4147f3842f27?auto=format&fit=crop&w=500&q=80',
    'https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?auto=format&fit=crop&w=500&q=80',
    'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?auto=format&fit=crop&w=500&q=80',
    'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=500&q=80',
    'https://images.unsplash.com/photo-1603252109303-2751441dd157?auto=format&fit=crop&w=500&q=80',
    'https://images.unsplash.com/photo-1556821840-3a63f95609a7?auto=format&fit=crop&w=500&q=80',
    'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=500&q=80',
];
@endphp

<div class="gr-section-header">
    <div class="gr-section-header-inner">
        <div>
            <div class="gr-section-label">INDEX — 02</div>
            <h2 class="gr-section-title">FRESH OFF THE PRESS</h2>
        </div>
        <a href="{{ route('products.all', ['sort'=>'new']) }}" class="gr-section-link">ALL ITEMS →</a>
    </div>
</div>

<div class="gr-product-grid gr-product-grid-3">
    @forelse($arrivals->take(6) as $i => $product)
    <a href="{{ $product->product_id ? route('product.view', $product->product_id) : route('products.all') }}" class="gr-product-card" id="product-card-{{ $product->id }}">
        <div class="gr-product-card-img">
            @auth
                @if($product->product_id)
                    @php
                        $inWishlist = auth()->user()->wishlistItems->contains('product_id', $product->product_id);
                    @endphp
                    <form action="{{ route('wishlist.toggle', $product->product_id) }}" method="POST" style="position: absolute; top: 10px; right: 10px; z-index: 5; margin: 0;">
                        @csrf
                        <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();" class="o-product-wishlist" style="display: flex; align-items: center; justify-content: center;" aria-label="Toggle Wishlist">
                            <i class="{{ $inWishlist ? 'fas' : 'far' }} fa-heart" aria-hidden="true" style="color: {{ $inWishlist ? 'var(--accent)' : 'inherit' }};"></i>
                        </button>
                    </form>
                @endif
            @endauth
            @if($i === 0)
                <span class="gr-badge gr-badge-new">New Drop</span>
            @elseif($i === 2 || $i === 5)
                <span class="gr-badge gr-badge-bestseller">Bestseller</span>
            @endif
            <img src="{{ asset('storage/' . $product->image) }}" 
                 onerror="this.src='{{ $phs[$i % 8] }}'" 
                 alt="{{ $product->name }}" loading="lazy">
            <span class="gr-product-view-btn">VIEW →</span>
        </div>
        <div class="gr-product-card-body" style="padding: 12px 2px 0 2px;">
            <div style="font-family: var(--font); font-size: 8px; color: var(--text-light); text-transform: uppercase; margin-bottom: 4px; letter-spacing: 0.5px; display: flex; justify-content: space-between;">
                <span>ITEM-0{{ $product->id }}</span>
                <span>ORIGINAL SHAPE</span>
            </div>
            <div class="gr-product-name" style="font-family: var(--font-serif); font-weight: 700; font-size: 15px; margin-bottom: 6px; color: var(--text);">{{ $product->name }}</div>
            <div class="gr-product-meta" style="margin-top: 4px; display: flex; justify-content: space-between; align-items: center;">
                <span class="gr-product-cat" style="font-size: 8px; font-weight: 700; color: var(--text-muted); letter-spacing: 0.08em; text-transform: uppercase;">MENSWEAR</span>
                <span class="gr-product-price" style="font-family: var(--font); font-weight: 700; color: var(--accent); font-size: 13px;">₹{{ number_format($product->price ?? 0) }}</span>
            </div>
        </div>
    </a>
    @empty
    <div style="grid-column:1/-1; text-align:center; padding:60px 20px;">
        <p style="color:var(--text-muted); font-size:13px;">Fresh drops coming soon. Check back later.</p>
    </div>
    @endforelse
</div>

{{-- ─── CUT FROM HONEST CLOTH (Editorial) ──────────────────── --}}
<section class="gr-editorial">
    <div class="gr-editorial-inner">
        <div class="gr-editorial-text">
            <div class="gr-editorial-label">FIELD NOTES — VOL. III</div>
            <h2 class="gr-editorial-heading">
                CUT FROM<br>
                <em>honest</em> CLOTH.
            </h2>
            <p class="gr-editorial-body">
                We build clothes for men who don't chase trends. Heavy fabrics. Honest stitching. Pieces that earn their fade.
            </p>
            <p class="gr-editorial-body-regular">
                Every piece in the GET READY catalog is made in small batches, washed twice, and tested by people who actually wear them. That's the whole story.
            </p>
            <a href="{{ route('manifesto') }}" class="gr-editorial-btn">READ THE MANIFESTO →</a>
        </div>
        <div class="gr-editorial-images">
            <div class="gr-editorial-img-1">
                <img src="https://images.unsplash.com/photo-1617137968427-85924c800a22?auto=format&fit=crop&w=700&q=80" 
                     alt="Man wearing printed shirt" loading="lazy">
            </div>
            <div class="gr-editorial-img-2">
                <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?auto=format&fit=crop&w=600&q=80" 
                     alt="Vintage clothing rack" loading="lazy">
            </div>
        </div>
    </div>
</section>

{{-- ─── SPIN THE OUTFIT WHEEL (CTA) ───────────────────────── --}}
<section class="gr-cta-upgraded" style="border: 1px solid var(--border); padding: 48px; background: var(--surface); box-shadow: 6px 6px 0px rgba(153,27,27,0.4); margin: 64px auto 0; max-width: var(--max-width); box-sizing: border-box;">
    <!-- Left side info -->
    <div>
        <div style="font-family: var(--font); font-size: 10px; font-weight: 700; color: var(--accent); letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 12px;">SYSTEM DEPLOYMENT — VOL. III</div>
        <h2 style="font-family: var(--font-heading); font-size: clamp(32px, 5vw, 48px); font-weight: 400; color: var(--text); line-height: 1.1; margin-top: 0; margin-bottom: 16px;">
            SPIN THE <span style="background: var(--accent); color: var(--white); padding: 2px 8px;">OUTFIT</span> WHEEL.
        </h2>
        <p style="font-family: var(--font-serif); font-style: italic; font-size: 14px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 24px;">
            Can't decide? Let algorithm-driven chance dress you. Our interactive Outfit Builder generates a full vintage, editorial combination in 3 seconds.
        </p>
        <a href="{{ route('outfit-builder') }}" class="gr-cta-btn" style="display: inline-flex; align-items: center; justify-content: center; text-decoration: none; padding: 14px 28px; font-size: 10px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;">TRY THE BUILDER →</a>
    </div>
    <!-- Right side physical spinning wheel graphic -->
    <div class="gr-cta-wheel-wrap" style="position: relative; display: flex; justify-content: center; align-items: center;">
        <div class="gr-cta-wheel" style="width: 200px; height: 200px; border-radius: 50%; border: 3px solid var(--primary); position: relative; background: repeating-conic-gradient(from 0deg, #1a1a1a 0deg 30deg, #111111 30deg 60deg); animation: spinBadge 20s linear infinite; box-shadow: 4px 4px 0px rgba(0,0,0,0.5); box-sizing: border-box;">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); width: 24px; height: 24px; background: var(--primary); border-radius: 50%; border: 2px solid var(--white); box-sizing: border-box;"></div>
            <!-- Radial ticks -->
            <div style="position: absolute; top: 10%; left: 50%; transform: translateX(-50%); font-family: var(--font); font-size: 8px; font-weight: bold; color: var(--text-light);">TEES</div>
            <div style="position: absolute; bottom: 10%; left: 50%; transform: translateX(-50%); font-family: var(--font); font-size: 8px; font-weight: bold; color: var(--text-light);">JEANS</div>
            <div style="position: absolute; left: 10%; top: 50%; transform: translateY(-50%); font-family: var(--font); font-size: 8px; font-weight: bold; color: var(--text-light); writing-mode: vertical-rl; transform-origin: center;">SHIRTS</div>
            <div style="position: absolute; right: 10%; top: 50%; transform: translateY(-50%); font-family: var(--font); font-size: 8px; font-weight: bold; color: var(--text-light); writing-mode: vertical-rl; transform-origin: center;">JACKETS</div>
        </div>
        <!-- Wheel pointer -->
        <div style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); width: 0; height: 0; border-left: 12px solid transparent; border-right: 12px solid transparent; border-top: 20px solid var(--accent); filter: drop-shadow(2px 2px 0px var(--primary));"></div>
    </div>
</section>

{{-- ─── TRUST FOOTER BADGES ───────────────────────────────── --}}
<section class="gr-trust-footer" style="background: var(--surface); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 56px 0; margin-top: 60px;">
    <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 32px; max-width: var(--max-width); margin: 0 auto; padding: 0 24px;">
        <div class="gr-trust-card" style="padding: 24px; border-right: 1px solid var(--border-light); text-align: center;">
            <div style="background: var(--cream); width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <i class="fas fa-truck-moving" style="font-size: 18px; color: var(--accent);"></i>
            </div>
            <h3 style="font-family: var(--font-heading); font-size: 18px; margin-bottom: 8px; letter-spacing: 0.5px; text-transform: uppercase;">FAST METRO DELIVERY</h3>
            <p style="font-size: 11px; color: var(--text-secondary); line-height: 1.6;">Free shipping on orders above ₹999. Orders dispatched within 24 hours.</p>
        </div>
        <div class="gr-trust-card" style="padding: 24px; border-right: 1px solid var(--border-light); text-align: center;">
            <div style="background: var(--cream); width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <i class="fas fa-recycle" style="font-size: 18px; color: var(--accent);"></i>
            </div>
            <h3 style="font-family: var(--font-heading); font-size: 18px; margin-bottom: 8px; letter-spacing: 0.5px; text-transform: uppercase;">SMALL BATCH CREATIONS</h3>
            <p style="font-size: 11px; color: var(--text-secondary); line-height: 1.6;">Limited release runs made responsibly with organic, extra-long staple cotton.</p>
        </div>
        <div class="gr-trust-card" style="padding: 24px; text-align: center;">
            <div style="background: var(--cream); width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <i class="fas fa-undo-alt" style="font-size: 18px; color: var(--accent);"></i>
            </div>
            <h3 style="font-family: var(--font-heading); font-size: 18px; margin-bottom: 8px; letter-spacing: 0.5px; text-transform: uppercase;">14-DAY EASY RETURNS</h3>
            <p style="font-size: 11px; color: var(--text-secondary); line-height: 1.6;">Return or exchange within 14 days of purchase. Simplified returns process.</p>
        </div>
    </div>
</section>

@endsection