@extends('layouts.front')
@section('title', 'GET READY — Premium Menswear')
@section('meta_description', 'Shop premium menswear at GET READY. Heavy fabrics. Honest stitching. Men\'s clothing store.')

@section('content')
    <style>
        /* Wishlist heart display on hover */
        .gr-product-card .o-product-wishlist {
            opacity: 0;
            position: absolute;
            top: 12px;
            right: 12px;
            z-index: 5;
            background: rgba(10, 10, 10, 0.75);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .gr-product-card:hover .o-product-wishlist {
            opacity: 1;
        }

        .gr-product-card .o-product-wishlist:hover {
            background: var(--white);
            color: #000;
            transform: scale(1.05);
        }

        /* ═══════════════════════════════════════════════════════════
           HERO — Clean Editorial Redesign
           ═══════════════════════════════════════════════════════════ */

        .gr-hero {
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.06) !important;
            background-color: #111111 !important;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.45) !important;
            margin: 40px auto !important;
            padding: 64px 80px !important;
            box-sizing: border-box !important;
            overflow: hidden;
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 60px;
            align-items: center;
        }

        .gr-hero-text,
        .gr-hero-images {
            position: relative;
            z-index: 2;
        }

        /* Orchestrated Reveal Sequence */
        @keyframes heroReveal {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .gr-hero-text > *,
        .gr-hero-images {
            animation: heroReveal 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .gr-hero-label {
            animation-delay: 0.05s;
            position: relative;
            font-family: var(--font);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--accent);
            padding-bottom: 8px;
            margin-bottom: 24px;
            display: inline-block;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .gr-hero-heading {
            animation-delay: 0.15s;
            font-family: var(--font-heading);
            font-size: clamp(48px, 6.5vw, 84px) !important;
            font-weight: 400;
            color: var(--text);
            line-height: 0.95;
            letter-spacing: 1px;
            margin-bottom: 24px;
        }

        .gr-hero-heading em {
            font-family: var(--font-serif);
            font-style: italic;
            font-weight: 400;
            color: var(--accent);
            font-size: 0.95em;
            text-transform: lowercase;
        }

        .gr-hero-subtitle {
            animation-delay: 0.25s;
            font-family: var(--font-serif);
            font-size: 16px;
            font-style: italic;
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 40px;
            max-width: 460px;
        }

        .gr-hero-btns {
            animation-delay: 0.35s;
            display: flex;
            gap: 16px;
        }

        .gr-hero-images {
            animation-delay: 0.3s;
            position: relative;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            min-height: 460px;
        }

        .gr-hero-img-1,
        .gr-hero-img-2 {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35);
            background: #151515;
        }

        .gr-hero-img-1 {
            align-self: start;
            margin-top: 20px;
            aspect-ratio: 3/4;
        }

        .gr-hero-img-2 {
            align-self: end;
            margin-bottom: 20px;
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
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-8px);
            }
        }

        .gr-hero-img-1 {
            animation: heroImageDrift 10s ease-in-out infinite;
        }

        .gr-hero-img-2 {
            animation: heroImageDrift 10s ease-in-out infinite;
            animation-delay: 5s;
        }

        /* Badge: Elegant rotating circular emblem */
        .gr-hero-circle-badge {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 4;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(15, 15, 15, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            animation: spinBadge 24s linear infinite, heroReveal 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            animation-delay: 0s, 0.5s;
            transition: all 0.3s ease;
        }

        .gr-hero-circle-badge span {
            font-family: var(--font);
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #fff;
            text-align: center;
            line-height: 1.4;
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
            transform: translate(-50%, -50%) scale(1.08);
            border-color: var(--accent);
        }

        /* Respect reduced-motion preference */
        @media (prefers-reduced-motion: reduce) {
            .gr-hero-text > *,
            .gr-hero-images,
            .gr-hero-img-1,
            .gr-hero-img-2,
            .gr-hero-circle-badge {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }

        /* ═══════════════════════════════════════════════════════════
           THE WARDROBE (Category Grid) Redesign
           ═══════════════════════════════════════════════════════════ */

        .gr-wardrobe-card {
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2) !important;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1) !important;
            background: var(--surface) !important;
        }

        .gr-wardrobe-card:hover {
            transform: translateY(-4px) !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4) !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
        }

        .gr-wardrobe-card img {
            transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        .gr-wardrobe-card:hover img {
            transform: scale(1.03) !important;
        }

        .gr-wardrobe-title {
            font-family: var(--font-heading) !important;
            font-size: clamp(18px, 2vw, 26px) !important;
            color: var(--white) !important;
            background: rgba(10, 10, 10, 0.75) !important;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: inline-block !important;
            padding: 6px 16px !important;
            margin-bottom: 8px !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            letter-spacing: 1px !important;
        }

        .gr-wardrobe-link {
            font-family: var(--font) !important;
            font-size: 8px !important;
            font-weight: 700 !important;
            letter-spacing: 0.1em !important;
            color: var(--white) !important;
            background: var(--primary) !important;
            padding: 6px 12px !important;
            border: none !important;
            display: inline-block !important;
            transition: all 0.3s ease !important;
        }

        .gr-wardrobe-overlay {
            transition: background 0.3s ease;
        }

        .gr-wardrobe-card:hover .gr-wardrobe-overlay {
            background: rgba(10, 10, 10, 0.25);
        }

        .gr-wardrobe-card:hover .gr-wardrobe-link {
            transform: translateX(4px);
            letter-spacing: 0.12em !important;
        }

        /* ═══════════════════════════════════════════════════════════
           PRODUCT CARDS (Modern Minimal Style)
           ═══════════════════════════════════════════════════════════ */

        .gr-product-card {
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            padding: 0px !important; /* Full bleed image layout */
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15) !important;
            background: #111111 !important;
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        .gr-product-card:hover {
            transform: translateY(-6px) !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4) !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
        }

        .gr-product-card-img {
            overflow: hidden;
            position: relative;
            aspect-ratio: 3/4 !important;
            border: none !important;
            background: #151515;
        }

        .gr-product-card-img img {
            transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        .gr-product-card:hover .gr-product-card-img img {
            transform: scale(1.04) !important;
        }

        .gr-product-view-btn {
            position: absolute;
            bottom: 16px;
            left: 50%;
            transform: translate(-50%, 10px);
            padding: 8px 20px;
            font-family: var(--font);
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            background: rgba(10, 10, 10, 0.85) !important;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #fff !important;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
            z-index: 2;
        }

        .gr-product-card:hover .gr-product-view-btn {
            opacity: 1 !important;
            transform: translate(-50%, 0) !important;
        }

        .gr-product-view-btn:hover {
            background: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        /* Editorial Float Animations */
        @keyframes floatEditorial1 {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        @keyframes floatEditorial2 {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }

        .gr-editorial-img-1 {
            animation: floatEditorial1 8s ease-in-out infinite;
        }

        .gr-editorial-img-2 {
            animation: floatEditorial2 8s ease-in-out infinite;
            animation-delay: 4s;
        }

        /* Trust footer card styling */
        .gr-trust-card {
            background: #111111 !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15) !important;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
            position: relative;
            z-index: 2;
        }

        .gr-trust-card:hover {
            transform: translateY(-4px) !important;
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.35) !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
        }

        .gr-trust-card i {
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .gr-trust-card:hover i {
            transform: scale(1.15) rotate(3deg);
        }

        /* Interactive button highlights */
        .gr-hero-btn-primary,
        .gr-hero-btn-outline,
        .gr-editorial-btn,
        .gr-cta-btn {
            position: relative;
            overflow: hidden;
            z-index: 1;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        /* ═══════════════════════════════════════════════════════════
           MOBILE BREAKPOINTS & RESPONSIVENESS
           ═══════════════════════════════════════════════════════════ */

        .gr-cta-upgraded {
            display: grid;
            grid-template-columns: 1.25fr 0.75fr;
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

            /* Hero mobile rules */
            .gr-hero {
                grid-template-columns: 1fr;
                padding: 40px 24px !important;
                margin: 20px 16px !important;
                width: calc(100% - 32px) !important;
                box-sizing: border-box !important;
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3) !important;
                gap: 32px;
            }

            .gr-hero-heading {
                font-size: clamp(36px, 10vw, 48px) !important;
                margin-bottom: 16px;
                letter-spacing: 0.5px;
            }

            .gr-hero-subtitle {
                font-size: 14px !important;
                margin-bottom: 32px !important;
            }

            .gr-hero-btns {
                flex-direction: column;
                gap: 12px;
                width: 100%;
            }

            .gr-hero-btn-primary,
            .gr-hero-btn-outline {
                width: 100%;
                text-align: center;
                justify-content: center;
                padding: 14px 20px !important;
            }

            .gr-hero-images {
                min-height: auto;
                margin-top: 12px;
                gap: 16px;
            }

            .gr-hero-img-1,
            .gr-hero-img-2 {
                margin: 0 !important;
                aspect-ratio: 3/4 !important;
                animation: none !important;
            }

            .gr-hero-circle-badge {
                width: 70px;
                height: 70px;
                display: none !important; /* Hide badge on mobile to avoid layout overlap */
            }

            /* Categories Grid on Mobile */
            .gr-wardrobe-grid {
                grid-template-columns: 1fr !important;
                grid-template-rows: auto !important;
                gap: 16px !important;
            }

            .gr-wardrobe-card-tall {
                grid-row: auto !important;
                min-height: 320px !important;
            }

            .gr-wardrobe-card-normal {
                aspect-ratio: 4/3 !important;
            }

            /* Product Grid on Mobile */
            .gr-product-grid-3 {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 16px !important;
                padding: 0 16px !important;
            }

            /* CTA block on Mobile */
            .gr-cta-upgraded {
                grid-template-columns: 1fr !important;
                padding: 40px 24px !important;
                margin: 40px 16px !important;
                width: calc(100% - 32px) !important;
                gap: 32px;
                text-align: center;
            }

            .gr-cta-upgraded h2 {
                font-size: clamp(24px, 7vw, 32px) !important;
            }

            .gr-cta-wheel-wrap {
                margin-top: 12px;
            }

            .gr-editorial-inner {
                grid-template-columns: 1fr !important;
                gap: 40px !important;
                padding: 0 16px !important;
            }

            .gr-editorial-images {
                gap: 16px !important;
            }

            .gr-editorial-img-1,
            .gr-editorial-img-2 {
                animation: none !important;
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
                <div class="gr-product-card-body">
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
    <section class="gr-cta-upgraded" style="margin: 80px auto 0 !important; max-width: var(--max-width); box-sizing: border-box;">
        <!-- Left side info -->
        <div>
            <div
                style="font-family: var(--font); font-size: 10px; font-weight: 700; color: var(--accent); letter-spacing: 0.15em; text-transform: uppercase; margin-bottom: 12px;">
                SYSTEM DEPLOYMENT — VOL. III</div>
            <h2
                style="font-family: var(--font-heading); font-size: clamp(32px, 5vw, 48px); font-weight: 400; color: var(--text); line-height: 1.1; margin-top: 0; margin-bottom: 16px;">
                SPIN THE <span style="background: var(--accent); color: var(--white); padding: 2px 8px;">OUTFIT</span> WHEEL.
            </h2>
            <p
                style="font-family: var(--font-serif); font-style: italic; font-size: 15px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 28px;">
                Can't decide? Let algorithm-driven chance dress you. Our interactive Outfit Builder generates a full
                vintage, editorial combination in 3 seconds.
            </p>
            <a href="{{ route('outfit-builder') }}" class="gr-cta-btn">TRY THE BUILDER →</a>
        </div>
        <!-- Right side physical spinning wheel graphic -->
        <div class="gr-cta-wheel-wrap"
            style="position: relative; display: flex; justify-content: center; align-items: center;">
            <div class="gr-cta-wheel"
                style="width: 200px; height: 200px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.15); position: relative; background: repeating-conic-gradient(from 0deg, #1a1a1a 0deg 30deg, #111111 30deg 60deg); animation: spinBadge 20s linear infinite; box-shadow: 0 15px 30px rgba(0,0,0,0.4); box-sizing: border-box;">
                <div
                    style="position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); width: 24px; height: 24px; background: var(--primary); border-radius: 50%; border: 2px solid var(--white); box-sizing: border-box;">
                </div>
                <!-- Radial ticks -->
                <div
                    style="position: absolute; top: 12%; left: 50%; transform: translateX(-50%); font-family: var(--font); font-size: 8px; font-weight: bold; color: var(--text-light); letter-spacing: 1px;">
                    TEES</div>
                <div
                    style="position: absolute; bottom: 12%; left: 50%; transform: translateX(-50%); font-family: var(--font); font-size: 8px; font-weight: bold; color: var(--text-light); letter-spacing: 1px;">
                    JEANS</div>
                <div
                    style="position: absolute; left: 12%; top: 50%; transform: translateY(-50%); font-family: var(--font); font-size: 8px; font-weight: bold; color: var(--text-light); writing-mode: vertical-rl; transform-origin: center; letter-spacing: 1px;">
                    SHIRTS</div>
                <div
                    style="position: absolute; right: 12%; top: 50%; transform: translateY(-50%); font-family: var(--font); font-size: 8px; font-weight: bold; color: var(--text-light); writing-mode: vertical-rl; transform-origin: center; letter-spacing: 1px;">
                    JACKETS</div>
            </div>
            <!-- Wheel pointer -->
            <div
                style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); width: 0; height: 0; border-left: 10px solid transparent; border-right: 10px solid transparent; border-top: 18px solid var(--accent); filter: drop-shadow(0 2px 4px rgba(0,0,0,0.5));">
            </div>
        </div>
    </section>

    {{-- ─── TRUST FOOTER BADGES ───────────────────────────────── --}}
    <section class="gr-trust-footer" style="margin-top: 80px;">
        <div class="container"
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 32px; max-width: var(--max-width); margin: 0 auto; padding: 0 24px;">
            <div class="gr-trust-card">
                <div
                    style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <i class="fas fa-truck-moving" style="font-size: 18px; color: var(--accent);"></i>
                </div>
                <h3
                    style="font-family: var(--font-heading); font-size: 18px; margin-bottom: 12px; letter-spacing: 0.5px; text-transform: uppercase; color: var(--text);">
                    FAST METRO DELIVERY</h3>
                <p style="font-size: 11px; color: var(--text-secondary); line-height: 1.6;">Free shipping on orders above
                    ₹999. Orders dispatched within 24 hours.</p>
            </div>
            <div class="gr-trust-card">
                <div
                    style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <i class="fas fa-recycle" style="font-size: 18px; color: var(--accent);"></i>
                </div>
                <h3
                    style="font-family: var(--font-heading); font-size: 18px; margin-bottom: 12px; letter-spacing: 0.5px; text-transform: uppercase; color: var(--text);">
                    SMALL BATCH CREATIONS</h3>
                <p style="font-size: 11px; color: var(--text-secondary); line-height: 1.6;">Limited release runs made
                    responsibly with organic, extra-long staple cotton.</p>
            </div>
            <div class="gr-trust-card">
                <div
                    style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <i class="fas fa-undo-alt" style="font-size: 18px; color: var(--accent);"></i>
                </div>
                <h3
                    style="font-family: var(--font-heading); font-size: 18px; margin-bottom: 12px; letter-spacing: 0.5px; text-transform: uppercase; color: var(--text);">
                    7-DAY EASY RETURNS</h3>
                <p style="font-size: 11px; color: var(--text-secondary); line-height: 1.6;">Return or exchange within 7 days
                    of purchase. Simplified returns process.</p>
            </div>
        </div>
    </section>

@endsection