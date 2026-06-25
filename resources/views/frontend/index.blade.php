@extends('layouts.front')
@section('title', 'GET READY — Premium Menswear')
@section('meta_description', 'Shop premium menswear at GET READY. Heavy fabrics. Honest stitching. Men\'s clothing store.')

@section('content')
    <style>
        /* Wishlist heart display on hover */
        .gr-product-card:hover .o-product-wishlist {
            opacity: 1;
        }

        /* ═══════════════════════════════════════════════════════════
           HERO — "Dispatch" redesign
           Concept: the hero reads like a printed zine cover / press
           dispatch — corner stamp, hairline rule under the eyebrow,
           tightened scanline as print-texture (not noise), and one
           orchestrated entrance instead of three unrelated ambient
           loops. Badge becomes a rotating ink stamp, not a generic
           spinning circle.
           ═══════════════════════════════════════════════════════════ */

        .gr-hero {
            position: relative;
            border: 3px solid var(--border) !important;
            background-color: var(--surface) !important;
            background-image: radial-gradient(rgba(255, 255, 255, 0.08) 2px, transparent 2px) !important;
            background-size: 24px 24px !important;
            box-shadow: 10px 10px 0px var(--primary) !important;
            margin: 40px auto !important;
            padding: 56px 64px !important;
            box-sizing: border-box !important;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 40px;
            align-items: center;
        }

        /* Corner stamp — registration-mark style, reinforces the
           "printed dispatch" idea without competing with the heading */
        .gr-hero::before {
            content: 'VOL. III';
            position: absolute;
            top: 18px;
            right: 22px;
            z-index: 3;
            font-family: var(--font);
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 0.25em;
            color: var(--text-muted);
            border: 1px solid var(--border);
            padding: 4px 8px;
            pointer-events: none;
        }

        /* Scanline kept, but tightened + lowered so it reads as paper
           texture rather than a layer of noise sitting on top of copy */
        .gr-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: repeating-linear-gradient(0deg,
                    transparent,
                    transparent 3px,
                    rgba(0, 0, 0, 0.05) 3px,
                    rgba(0, 0, 0, 0.05) 4px);
            pointer-events: none;
            z-index: 1;
            mix-blend-mode: multiply;
        }

        .gr-hero-text,
        .gr-hero-images {
            position: relative;
            z-index: 2;
        }

        /* ─── One orchestrated entrance ───
           Each element still fades up, but timed as a single sequence
           (label → rule → heading → subtitle → buttons → images) so it
           reads as one deliberate reveal, not scattered effects. */
        @keyframes heroReveal {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .gr-hero-text>*,
        .gr-hero-images {
            animation: heroReveal 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .gr-hero-label {
            animation-delay: 0.05s;
            position: relative;
            font-family: var(--font);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--accent);
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        /* Hairline rule under the eyebrow — a structural device that
           actually does something: separates "issue metadata" from
           the headline, like a masthead rule under a dateline */
        .gr-hero-label::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 64px;
            height: 2px;
            background: var(--primary);
        }

        .gr-hero-heading {
            animation-delay: 0.18s;
        }

        .gr-hero-subtitle {
            animation-delay: 0.32s;
        }

        .gr-hero-btns {
            animation-delay: 0.46s;
        }

        .gr-hero-images {
            animation-delay: 0.3s;
        }

        /* ─── Hero image composition ───
           Two images, deliberately offset, sharing one quiet float
           instead of two competing independent loops. */
        .gr-hero-images {
            position: relative;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            min-height: 420px;
        }

        .gr-hero-img-1,
        .gr-hero-img-2 {
            position: relative;
            overflow: hidden;
            border: 2px solid var(--border);
            box-shadow: 6px 6px 0px rgba(153, 27, 27, 0.35);
        }

        .gr-hero-img-1 {
            align-self: start;
            margin-top: 36px;
            aspect-ratio: 3/4;
        }

        .gr-hero-img-2 {
            align-self: end;
            margin-bottom: 36px;
            aspect-ratio: 3/4;
        }

        .gr-hero-img-1 img,
        .gr-hero-img-2 img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        @keyframes heroImageDrift {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-6px);
            }
        }

        .gr-hero-img-1 {
            animation: heroImageDrift 8s ease-in-out infinite;
        }

        .gr-hero-img-2 {
            animation: heroImageDrift 8s ease-in-out infinite;
            animation-delay: 4s;
        }

        /* ─── Badge: rotating ink stamp ───
           Replaces the generic spinning circle with a stamp motif that
           matches the dispatch concept — sits on the seam between the
           two images, looks pressed rather than floating. */
        .gr-hero-circle-badge {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 4;
            width: 92px;
            height: 92px;
            border-radius: 50%;
            background: var(--primary);
            border: 2px solid var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 3px 3px 0px rgba(0, 0, 0, 0.4);
            animation: spinBadge 18s linear infinite, heroReveal 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            animation-delay: 0s, 0.6s;
        }

        .gr-hero-circle-badge span {
            font-family: var(--font);
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--white);
            text-align: center;
            line-height: 1.5;
        }

        @keyframes spinBadge {
            from {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .gr-hero-circle-badge:hover {
            animation-play-state: paused, running;
            transform: translate(-50%, -50%) scale(1.12);
        }

        /* Respect reduced-motion preference */
        @media (prefers-reduced-motion: reduce) {

            .gr-hero-text>*,
            .gr-hero-images,
            .gr-hero-img-1,
            .gr-hero-img-2,
            .gr-hero-circle-badge {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }

        /* ─── Premium Home Page Animations & Styling (unchanged sections below) ─── */

        /* 6. Wardrobe Grid neat catalog borders and offset shadows */
        .gr-wardrobe-card {
            border: 1px solid var(--border) !important;
            box-shadow: 3px 3px 0px rgba(153, 27, 27, 0.4) !important;
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
            background: rgba(0, 0, 0, 0.7) !important;
            display: inline-block !important;
            padding: 4px 12px !important;
            margin-bottom: 8px !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
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
            box-shadow: 4px 4px 0px rgba(153, 27, 27, 0.35) !important;
            background: var(--surface) !important;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        .gr-product-card:hover {
            transform: translateY(-4px) !important;
            box-shadow: 7px 7px 0px rgba(153, 27, 27, 0.5) !important;
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

            0%,
            100% {
                transform: translateY(0px) scale(1);
            }

            50% {
                transform: translateY(-6px) scale(1.01);
            }
        }

        @keyframes floatEditorial2 {

            0%,
            100% {
                transform: translateY(0px) scale(1);
            }

            50% {
                transform: translateY(-8px) scale(0.99);
            }
        }

        .gr-editorial-img-1 {
            animation: floatEditorial1 8s ease-in-out infinite;
        }

        .gr-editorial-img-2 {
            animation: floatEditorial2 8s ease-in-out infinite;
            animation-delay: 4s;
        }

        /* 7. Hover effects on trust card icons - Retro styling */
        .gr-trust-card {
            background: var(--surface);
            border: 2px solid var(--border);
            box-shadow: 5px 5px 0px var(--primary);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            z-index: 2;
        }

        .gr-trust-card:hover {
            transform: translate(-3px, -3px);
            box-shadow: 8px 8px 0px var(--accent);
            border-color: var(--border) !important;
        }

        .gr-trust-card i {
            transition: transform 0.4s ease;
        }

        .gr-trust-card:hover i {
            transform: scale(1.2) rotate(5deg);
        }

        /* 8. Interactive button highlights */
        .gr-hero-btn-primary,
        .gr-hero-btn-outline,
        .gr-editorial-btn,
        .gr-cta-btn {
            position: relative;
            overflow: hidden;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .gr-hero-btn-primary:hover,
        .gr-editorial-btn:hover,
        .gr-cta-btn:hover {
            box-shadow: 0 8px 16px rgba(26, 26, 26, 0.15);
        }

        /* 9. Mobile Responsive Fixes */
        .gr-cta-upgraded {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 48px;
            align-items: center;
        }

        html,
        body {
            max-width: 100vw !important;
            overflow-x: hidden !important;
        }

        @media (max-width: 768px) {
            .gr-wardrobe-card {
                max-width: 100% !important;
                box-sizing: border-box !important;
                overflow: hidden !important;
            }

            .gr-wardrobe {
                padding: 0 16px 40px !important;
                overflow-x: hidden !important;
                width: 100% !important;
                box-sizing: border-box !important;
            }

            /* ── Hero mobile rules (kept alongside other mobile fixes) ── */
            .gr-hero {
                grid-template-columns: 1fr;
                padding: 32px 20px !important;
                margin: 0 !important;
                width: 100% !important;
                box-sizing: border-box !important;
                box-shadow: none !important;
                border-left: none !important;
                border-right: none !important;
                border-radius: 0 !important;
                gap: 24px;
            }

            .gr-hero::before {
                font-size: 8px;
                top: 14px;
                right: 14px;
            }

            .gr-cta-upgraded {
                grid-template-columns: 1fr;
                padding: 40px 16px !important;
                gap: 32px;
                text-align: center;
                margin: 32px 0 0 !important;
                width: 100% !important;
                box-sizing: border-box !important;
                border-left: none !important;
                border-right: none !important;
                border-radius: 0 !important;
                box-shadow: none !important;
            }

            .gr-cta-upgraded h2 {
                font-size: clamp(24px, 7vw, 32px) !important;
            }

            .gr-hero-heading {
                font-size: clamp(32px, 12vw, 48px) !important;
                margin-bottom: 16px;
                letter-spacing: 1px;
            }

            .gr-hero-subtitle {
                font-size: 13px !important;
                margin-bottom: 24px !important;
            }

            .gr-hero-btns {
                display: flex;
                flex-direction: column;
                gap: 12px;
                width: 100%;
            }

            .gr-hero-btn-primary,
            .gr-hero-btn-outline {
                width: 100%;
                text-align: center;
                justify-content: center;
                padding: 16px !important;
            }

            .gr-hero-images {
                min-height: auto;
                margin-top: 4px;
                gap: 12px;
            }

            .gr-hero-img-1,
            .gr-hero-img-2 {
                margin: 0 !important;
                aspect-ratio: 4/5 !important;
                animation: none !important;
            }

            .gr-hero-circle-badge {
                display: none !important;
                /* Hide badge on mobile to avoid clutter */
            }

            .gr-editorial-inner {
                flex-direction: column !important;
            }
        }
    </style>

    {{-- ─── LANDING HERO ───────────────────────────────────────── --}}
    @php
        $activeCarousels = \App\Models\Carousel::where('is_active', true)->latest()->take(2)->get();
        $heroImg1 = $activeCarousels->count() > 0 && $activeCarousels[0]->image_path ? asset('storage/' . $activeCarousels[0]->image_path) : asset('assets/images/hero1.jpg');
        $heroImg2 = $activeCarousels->count() > 1 && $activeCarousels[1]->image_path ? asset('storage/' . $activeCarousels[1]->image_path) : asset('assets/images/hero2.jpg');

        $heroTitle = $activeCarousels->count() > 0 && $activeCarousels[0]->title ? $activeCarousels[0]->title : "MEN'S<br>CLOTHING<br><em>store</em>";
        $heroSubtitle = $activeCarousels->count() > 0 && $activeCarousels[0]->description ? $activeCarousels[0]->description : "Premium menswear. Made for the road.";
        $heroBtnText = $activeCarousels->count() > 0 && $activeCarousels[0]->button_text ? $activeCarousels[0]->button_text : "SHOP THE DROP →";
        $heroBtnLink = $activeCarousels->count() > 0 && $activeCarousels[0]->button_link ? $activeCarousels[0]->button_link : route('products.all');
    @endphp

    <section class="gr-hero">
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const slideshows = document.querySelectorAll('.hover-slideshow');
                slideshows.forEach(img => {
                    let images = [];
                    try { images = JSON.parse(img.getAttribute('data-images')); } catch (e) { }

                    if (images.length > 1) {
                        let interval;
                        let currentIndex = 0;
                        let originalSrc = img.src;

                        // Preload images for smooth sliding
                        images.forEach(src => {
                            const preload = new Image();
                            preload.src = src;
                        });

                        img.closest('.gr-product-card').addEventListener('mouseenter', () => {
                            originalSrc = img.src; // save original
                            interval = setInterval(() => {
                                currentIndex = (currentIndex + 1) % images.length;
                                img.src = images[currentIndex];
                            }, 600); // Fast sliding (600ms per image)
                        });

                        img.closest('.gr-product-card').addEventListener('mouseleave', () => {
                            clearInterval(interval);
                            currentIndex = 0;
                            img.src = originalSrc;
                        });
                    }
                });
            });
        </script>

        <div class="gr-hero-text">
            <div class="gr-hero-label">FALL / WINTER '26 — VOL. III</div>
            <h1 class="gr-hero-heading" style="text-transform: uppercase;">
                {!! $heroTitle !!}
            </h1>
            <p class="gr-hero-subtitle">
                {{ $heroSubtitle }}
            </p>
            <div class="gr-hero-btns">
                <a href="{{ $heroBtnLink }}" class="gr-hero-btn-primary">{{ $heroBtnText }}</a>
                <a href="{{ route('outfit-builder') }}" class="gr-hero-btn-outline">OUTFIT BUILDER</a>
            </div>
        </div>
        <div class="gr-hero-images">
            <div class="gr-hero-img-1">
                <img src="{{ $heroImg1 }}" alt="Lifestyle editorial" loading="eager">
            </div>
            <div class="gr-hero-img-2">
                <img src="{{ $heroImg2 }}" alt="Street style fashion" loading="eager">
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
                <span class="gr-marquee-item">formals</span>
                <span class="gr-marquee-dot">✦</span>
                <span class="gr-marquee-item">Street wear</span>
                <span class="gr-marquee-dot">✦</span>
                <span class="gr-marquee-item">vintage style</span>
                <span class="gr-marquee-dot">✦</span>
                <span class="gr-marquee-item">casuals</span>
                <span class="gr-marquee-dot">✦</span>
                <span class="gr-marquee-item">formals</span>
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
            asset('assets/images/official-logo.jpg'),
            asset('assets/images/logo.png'),
            asset('assets/images/logo.png'),
            asset('assets/images/logo.png'),
            asset('assets/images/logo.png'),
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
                <a href="{{ url($categories->first()->slug) }}" class="gr-wardrobe-card gr-wardrobe-card-tall"
                    aria-label="Shop {{ $categories->first()->name }}">
                    <img src="{{ asset('storage/' . $categories->first()->image) }}" onerror="this.src='{{ $wardrobeImgs[0] }}'"
                        alt="{{ $categories->first()->name }}" loading="lazy">
                    <div class="gr-wardrobe-overlay">
                        <div class="gr-wardrobe-title">{{ strtoupper($categories->first()->name) }}</div>
                        <span class="gr-wardrobe-link">SHOP {{ strtoupper($categories->first()->name) }} →</span>
                    </div>
                </a>
            @endif

            {{-- Top-right 2 cards --}}
            @foreach($categories->skip(1)->take(2) as $i => $cat)
                <a href="{{ url($cat->slug) }}" class="gr-wardrobe-card gr-wardrobe-card-normal"
                    aria-label="Shop {{ $cat->name }}">
                    <img src="{{ asset('storage/' . $cat->image) }}" onerror="this.src='{{ $wardrobeImgs[($i + 1) % 5] }}'"
                        alt="{{ $cat->name }}" loading="lazy">
                    <div class="gr-wardrobe-overlay">
                        <div class="gr-wardrobe-title">{{ strtoupper($cat->name) }}</div>
                        <span class="gr-wardrobe-link">SHOP {{ strtoupper($cat->name) }} →</span>
                    </div>
                </a>
            @endforeach

            {{-- Bottom-right 2 cards --}}
            @foreach($categories->skip(3)->take(2) as $i => $cat)
                <a href="{{ url($cat->slug) }}" class="gr-wardrobe-card gr-wardrobe-card-normal"
                    aria-label="Shop {{ $cat->name }}">
                    <img src="{{ asset('storage/' . $cat->image) }}" onerror="this.src='{{ $wardrobeImgs[($i + 3) % 5] }}'"
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

    <div class="gr-section-header">
        <div class="gr-section-header-inner">
            <div>
                <div class="gr-section-label">INDEX — 02</div>
                <h2 class="gr-section-title">FRESH OFF THE PRESS</h2>
            </div>
            <a href="{{ route('products.all', ['sort' => 'new']) }}" class="gr-section-link">ALL ITEMS →</a>
        </div>
    </div>

    <div class="gr-product-grid gr-product-grid-3">
        @forelse($arrivals->take(6) as $i => $product)
            <a href="{{ $product->product_id ? route('product.view', $product->product_id) : route('products.all') }}"
                class="gr-product-card" id="product-card-{{ $product->id }}">
                <div class="gr-product-card-img">
                    @auth
                        @if($product->product_id)
                            @php
                                $inWishlist = auth()->user()->wishlistItems->contains('product_id', $product->product_id);
                            @endphp
                            <form action="{{ route('wishlist.toggle', $product->product_id) }}" method="POST"
                                style="position: absolute; top: 10px; right: 10px; z-index: 5; margin: 0;">
                                @csrf
                                <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="o-product-wishlist" style="display: flex; align-items: center; justify-content: center;"
                                    aria-label="Toggle Wishlist">
                                    <i class="{{ $inWishlist ? 'fas' : 'far' }} fa-heart" aria-hidden="true"
                                        style="color: {{ $inWishlist ? 'var(--accent)' : 'inherit' }};"></i>
                                </button>
                            </form>
                        @endif
                    @endauth
                    @if($i === 0)
                        <span class="gr-badge gr-badge-new">New Drop</span>
                    @elseif($i === 2 || $i === 5)
                        <span class="gr-badge gr-badge-bestseller">Bestseller</span>
                    @endif
                    @php
                        $validImages = array_filter([$product->image, $product->image_2, $product->image_3, $product->image_4]);
                        $imageUrls = array_map(function ($img) {
                            return asset('storage/' . $img);
                        }, array_values($validImages));
                    @endphp
                    <img src="{{ asset('storage/' . $product->image) }}" onerror="this.src='{{ $phs[$i % 8] }}'"
                        data-images='@json($imageUrls)' class="hover-slideshow" alt="{{ $product->name }}" loading="lazy">
                    <span class="gr-product-view-btn">VIEW →</span>
                </div>
                <div class="gr-product-card-body" style="padding: 12px 2px 0 2px;">
                    <div
                        style="font-family: var(--font); font-size: 8px; color: var(--text-light); text-transform: uppercase; margin-bottom: 4px; letter-spacing: 0.5px; display: flex; justify-content: space-between;">
                        <span>ITEM-0{{ $product->id }}</span>
                        <span>ORIGINAL SHAPE</span>
                    </div>
                    <div class="gr-product-name"
                        style="font-family: var(--font-serif); font-weight: 700; font-size: 15px; margin-bottom: 6px; color: var(--text);">
                        {{ $product->name }}
                    </div>
                    <div class="gr-product-meta"
                        style="margin-top: 4px; display: flex; justify-content: space-between; align-items: center;">
                        <span class="gr-product-cat"
                            style="font-size: 8px; font-weight: 700; color: var(--text-muted); letter-spacing: 0.08em; text-transform: uppercase;">MENSWEAR</span>
                        <span class="gr-product-price"
                            style="font-family: var(--font); font-weight: 700; color: var(--accent); font-size: 13px;">₹{{ number_format($product->price ?? 0) }}</span>
                    </div>
                </div>
            </a>
        @empty
            <div style="grid-column:1/-1; text-align:center; padding:60px 20px;">
                <p style="color:var(--text-muted); font-size:13px;">Fresh drops coming soon. Check back later.</p>
            </div>
        @endforelse
    </div>

    {{-- ─── CUT FROM HONEST CLOTH (Editorial / Featured Product) ─── --}}
    @php
        $featuredProduct = \App\Models\FeaturedProduct::where('is_active', true)->latest()->first();
        $featTagline = $featuredProduct->tagline ?? "FIELD NOTES — VOL. III";
        $featTitle = $featuredProduct->title ?? "CUT FROM<br><em>honest</em> CLOTH.";
        $featDesc = $featuredProduct->description ?? "We build clothes for men who don't chase trends. Heavy fabrics. Honest stitching. Pieces that earn their fade.\n\nEvery piece in the GET READY catalog is made in small batches, washed twice, and tested by people who actually wear them. That's the whole story.";
        $featBtnText = $featuredProduct->button_text ?? "READ THE MANIFESTO →";
        $featBtnLink = $featuredProduct->button_link ?? route('manifesto');
        $featImg1 = $featuredProduct && $featuredProduct->image_path ? asset('storage/' . $featuredProduct->image_path) : asset('assets/images/official-logo.jpg');
        $featImg2 = asset('assets/images/logo.png');
    @endphp

    <section class="gr-editorial">
        <div class="gr-editorial-inner">
            <div class="gr-editorial-text">
                <div class="gr-editorial-label">{{ $featTagline }}</div>
                <h2 class="gr-editorial-heading">
                    {!! $featTitle !!}
                </h2>
                <div class="gr-editorial-body" style="white-space: pre-line;">
                    {{ $featDesc }}
                </div>

                @if($featuredProduct && $featuredProduct->discounted_price > 0)
                    <div style="margin-top: 16px; margin-bottom: 24px;">
                        <span
                            style="font-family: var(--font-heading); font-size: 24px; color: var(--accent);">₹{{ number_format($featuredProduct->discounted_price) }}</span>
                        @if($featuredProduct->original_price > $featuredProduct->discounted_price)
                            <span
                                style="text-decoration: line-through; color: var(--text-muted); font-size: 14px; margin-left: 8px;">₹{{ number_format($featuredProduct->original_price) }}</span>
                        @endif
                    </div>
                @endif

            </div>
            <div class="gr-editorial-images">
                <div class="gr-editorial-img-1">
                    <img src="{{ $featImg1 }}" alt="Featured Product" loading="lazy">
                </div>
                <div class="gr-editorial-img-2">
                    <img src="{{ $featImg2 }}" alt="Vintage clothing rack" loading="lazy">
                </div>
            </div>
        </div>
    </section>

    {{-- ─── SPIN THE OUTFIT WHEEL (CTA) ───────────────────────── --}}
    <section class="gr-cta-upgraded"
        style="border: 1px solid var(--border); padding: 48px; background: var(--surface); box-shadow: 6px 6px 0px rgba(153,27,27,0.4); margin: 64px auto 0; max-width: var(--max-width); box-sizing: border-box;">
        <!-- Left side info -->
        <div>
            <div
                style="font-family: var(--font); font-size: 10px; font-weight: 700; color: var(--accent); letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 12px;">
                SYSTEM DEPLOYMENT — VOL. III</div>
            <h2
                style="font-family: var(--font-heading); font-size: clamp(32px, 5vw, 48px); font-weight: 400; color: var(--text); line-height: 1.1; margin-top: 0; margin-bottom: 16px;">
                SPIN THE <span style="background: var(--accent); color: var(--white); padding: 2px 8px;">OUTFIT</span>
                WHEEL.
            </h2>
            <p
                style="font-family: var(--font-serif); font-style: italic; font-size: 14px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 24px;">
                Can't decide? Let algorithm-driven chance dress you. Our interactive Outfit Builder generates a full
                vintage, editorial combination in 3 seconds.
            </p>
            <a href="{{ route('outfit-builder') }}" class="gr-cta-btn"
                style="display: inline-flex; align-items: center; justify-content: center; text-decoration: none; padding: 14px 28px; font-size: 10px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;">TRY
                THE BUILDER →</a>
        </div>
        <!-- Right side physical spinning wheel graphic -->
        <div class="gr-cta-wheel-wrap"
            style="position: relative; display: flex; justify-content: center; align-items: center;">
            <div class="gr-cta-wheel"
                style="width: 200px; height: 200px; border-radius: 50%; border: 3px solid var(--primary); position: relative; background: repeating-conic-gradient(from 0deg, #1a1a1a 0deg 30deg, #111111 30deg 60deg); animation: spinBadge 20s linear infinite; box-shadow: 4px 4px 0px rgba(0,0,0,0.5); box-sizing: border-box;">
                <div
                    style="position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); width: 24px; height: 24px; background: var(--primary); border-radius: 50%; border: 2px solid var(--white); box-sizing: border-box;">
                </div>
                <!-- Radial ticks -->
                <div
                    style="position: absolute; top: 10%; left: 50%; transform: translateX(-50%); font-family: var(--font); font-size: 8px; font-weight: bold; color: var(--text-light);">
                    TEES</div>
                <div
                    style="position: absolute; bottom: 10%; left: 50%; transform: translateX(-50%); font-family: var(--font); font-size: 8px; font-weight: bold; color: var(--text-light);">
                    JEANS</div>
                <div
                    style="position: absolute; left: 10%; top: 50%; transform: translateY(-50%); font-family: var(--font); font-size: 8px; font-weight: bold; color: var(--text-light); writing-mode: vertical-rl; transform-origin: center;">
                    SHIRTS</div>
                <div
                    style="position: absolute; right: 10%; top: 50%; transform: translateY(-50%); font-family: var(--font); font-size: 8px; font-weight: bold; color: var(--text-light); writing-mode: vertical-rl; transform-origin: center;">
                    JACKETS</div>
            </div>
            <!-- Wheel pointer -->
            <div
                style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); width: 0; height: 0; border-left: 12px solid transparent; border-right: 12px solid transparent; border-top: 20px solid var(--accent); filter: drop-shadow(2px 2px 0px var(--primary));">
            </div>
        </div>
    </section>

    {{-- ─── TRUST FOOTER BADGES ───────────────────────────────── --}}
    <section class="gr-trust-footer"
        style="background: var(--surface); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); padding: 56px 0; margin-top: 60px;">
        <div class="container"
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 32px; max-width: var(--max-width); margin: 0 auto; padding: 0 24px;">
            <div class="gr-trust-card"
                style="padding: 24px; border-right: 1px solid var(--border-light); text-align: center;">
                <div
                    style="background: var(--cream); width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="fas fa-truck-moving" style="font-size: 18px; color: var(--accent);"></i>
                </div>
                <h3
                    style="font-family: var(--font-heading); font-size: 18px; margin-bottom: 8px; letter-spacing: 0.5px; text-transform: uppercase;">
                    FAST METRO DELIVERY</h3>
                <p style="font-size: 11px; color: var(--text-secondary); line-height: 1.6;">Free shipping on orders above
                    ₹999. Orders dispatched within 24 hours.</p>
            </div>
            <div class="gr-trust-card"
                style="padding: 24px; border-right: 1px solid var(--border-light); text-align: center;">
                <div
                    style="background: var(--cream); width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="fas fa-recycle" style="font-size: 18px; color: var(--accent);"></i>
                </div>
                <h3
                    style="font-family: var(--font-heading); font-size: 18px; margin-bottom: 8px; letter-spacing: 0.5px; text-transform: uppercase;">
                    SMALL BATCH CREATIONS</h3>
                <p style="font-size: 11px; color: var(--text-secondary); line-height: 1.6;">Limited release runs made
                    responsibly with organic, extra-long staple cotton.</p>
            </div>
            <div class="gr-trust-card" style="padding: 24px; text-align: center;">
                <div
                    style="background: var(--cream); width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i class="fas fa-undo-alt" style="font-size: 18px; color: var(--accent);"></i>
                </div>
                <h3
                    style="font-family: var(--font-heading); font-size: 18px; margin-bottom: 8px; letter-spacing: 0.5px; text-transform: uppercase;">
                    7-DAY EASY RETURNS</h3>
                <p style="font-size: 11px; color: var(--text-secondary); line-height: 1.6;">Return or exchange within 7 days
                    of purchase. Simplified returns process.</p>
            </div>
        </div>
    </section>

@endsection