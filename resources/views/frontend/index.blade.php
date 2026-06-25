@extends('layouts.front')
@section('title', 'GET READY — Premium Menswear')
@section('meta_description', 'Shop premium menswear at GET READY. Heavy fabrics. Honest stitching. Men\'s clothing store in Coimbatore.')

@section('content')
<style>
    /* ─────────────────────────────────────────────────────────────
       GET READY — HOMEPAGE COMPLETE UI
    ───────────────────────────────────────────────────────────── */

    /* ── HERO SECTION ── */
    .gr-hero {
        position: relative;
        max-width: var(--max-width);
        margin: 32px auto !important;
        padding: 0 24px !important;
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 0 !important;
        align-items: stretch !important;
        min-height: 580px !important;
        border: none !important;
        background: none !important;
        box-shadow: none !important;
        overflow: visible !important;
    }
    .gr-hero::after { display: none !important; }

    /* ── LEFT HERO PANEL — the "unique box" ── */
    .gr-hero-panel {
        background: #0f0f0f;
        border: 1px solid #2a2a2a;
        padding: 52px 48px;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        z-index: 1;
        box-shadow: 8px 8px 0 #991b1b;
    }
    /* Diagonal stripe texture */
    .gr-hero-panel::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            repeating-linear-gradient(
                -45deg,
                transparent,
                transparent 18px,
                rgba(153, 27, 27, 0.045) 18px,
                rgba(153, 27, 27, 0.045) 19px
            );
        pointer-events: none;
        z-index: 0;
    }
    /* Large ghost background text */
    .gr-hero-panel::after {
        content: 'GR';
        position: absolute;
        bottom: -30px;
        right: -20px;
        font-family: var(--font-heading);
        font-size: 280px;
        font-weight: 400;
        color: rgba(255,255,255,0.025);
        line-height: 1;
        pointer-events: none;
        z-index: 0;
        user-select: none;
    }

    .gr-hero-text { position: relative; z-index: 2; }
    .gr-hero-images { position: relative; z-index: 2; }

    /* Season tag */
    .gr-hero-label {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-family: var(--font);
        font-size: 9px;
        color: var(--text-muted);
        letter-spacing: 0.12em;
        text-transform: uppercase;
        margin-bottom: 28px;
        position: relative;
        z-index: 2;
    }
    .gr-hero-label::before {
        content: '';
        display: block;
        width: 28px;
        height: 1px;
        background: #991b1b;
        flex-shrink: 0;
    }

    /* Big heading */
    .gr-hero-heading {
        font-family: var(--font-heading);
        font-size: clamp(52px, 6.5vw, 100px);
        font-weight: 400;
        color: #f0ece3;
        line-height: 0.92;
        letter-spacing: 1px;
        margin-bottom: 20px;
        position: relative;
        z-index: 2;
        text-transform: uppercase;
    }
    .gr-hero-heading em {
        font-family: var(--font-serif);
        font-style: italic;
        color: #991b1b;
        font-size: 0.82em;
        letter-spacing: 0;
    }

    /* Subtitle */
    .gr-hero-subtitle {
        font-family: var(--font-serif);
        font-size: 14px;
        font-style: italic;
        color: #777;
        line-height: 1.75;
        max-width: 340px;
        margin-bottom: 36px;
        position: relative;
        z-index: 2;
    }

    /* CTA buttons */
    .gr-hero-btns {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        position: relative;
        z-index: 2;
    }
    .gr-hero-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 30px;
        background: #991b1b;
        color: #fff;
        border: none;
        font-family: var(--font);
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        cursor: pointer;
        transition: all 0.25s ease;
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }
    .gr-hero-btn-primary::before {
        content: '';
        position: absolute;
        inset: 0;
        background: #fff;
        transform: translateX(-101%);
        transition: transform 0.35s cubic-bezier(0.16,1,0.3,1);
        z-index: 0;
    }
    .gr-hero-btn-primary:hover::before { transform: translateX(0); }
    .gr-hero-btn-primary:hover { color: #991b1b; }
    .gr-hero-btn-primary span { position: relative; z-index: 1; }

    .gr-hero-btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 14px 28px;
        background: transparent;
        color: #e8e8e8;
        border: 1px solid #3a3a3a;
        font-family: var(--font);
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        cursor: pointer;
        transition: all 0.25s ease;
        text-decoration: none;
    }
    .gr-hero-btn-outline:hover {
        border-color: #e8e8e8;
        color: #fff;
        background: rgba(255,255,255,0.05);
    }

    /* Bottom meta strip */
    .gr-hero-meta-strip {
        display: flex;
        align-items: center;
        gap: 28px;
        padding-top: 36px;
        border-top: 1px solid #1e1e1e;
        margin-top: 40px;
        position: relative;
        z-index: 2;
    }
    .gr-hero-meta-item {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .gr-hero-meta-num {
        font-family: var(--font-heading);
        font-size: 28px;
        color: #f0ece3;
        line-height: 1;
    }
    .gr-hero-meta-label {
        font-family: var(--font);
        font-size: 8px;
        color: #555;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }
    .gr-hero-meta-divider {
        width: 1px;
        height: 32px;
        background: #222;
    }

    /* ── RIGHT HERO — Image Panel ── */
    .gr-hero-images {
        display: grid;
        grid-template-rows: 1fr 1fr;
        gap: 4px;
        position: relative;
        min-height: 580px;
    }
    .gr-hero-img-1, .gr-hero-img-2 {
        position: relative;
        overflow: hidden;
        background: #111;
        animation: none !important;
        box-shadow: none !important;
        width: 100% !important;
        height: 100% !important;
    }
    .gr-hero-img-1 { top: 0 !important; right: 0 !important; }
    .gr-hero-img-2 { bottom: 0 !important; left: 0 !important; }
    .gr-hero-img-1 img,
    .gr-hero-img-2 img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        object-position: center !important;
        transition: transform 0.8s cubic-bezier(0.16,1,0.3,1) !important;
        display: block;
    }
    .gr-hero-images:hover .gr-hero-img-1 img,
    .gr-hero-images:hover .gr-hero-img-2 img { transform: scale(1.04) !important; }

    /* Image overlay gradient */
    .gr-hero-img-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,0.5) 100%);
        z-index: 1;
        pointer-events: none;
    }

    /* Floating status badge on image */
    .gr-img-badge {
        position: absolute;
        bottom: 16px;
        left: 16px;
        z-index: 2;
        background: rgba(0,0,0,0.75);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255,255,255,0.12);
        padding: 8px 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .gr-img-badge-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #22c55e;
        animation: gr-pulse-dot 2s ease-in-out infinite;
        flex-shrink: 0;
    }
    @keyframes gr-pulse-dot {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.5); }
    }
    .gr-img-badge-text {
        font-family: var(--font);
        font-size: 8px;
        font-weight: 700;
        color: #e8e8e8;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    /* Circle badge spinner */
    .gr-hero-circle-badge {
        position: absolute;
        top: 50%;
        left: -28px;
        transform: translateY(-50%);
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: #991b1b;
        color: #fff;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 10;
        box-shadow: 0 4px 20px rgba(153,27,27,0.5);
    }
    .gr-hero-circle-badge span {
        font-family: var(--font);
        font-size: 5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        line-height: 1.3;
        text-align: center;
    }
    @keyframes spinBadge {
        from { transform: translateY(-50%) rotate(0deg); }
        to { transform: translateY(-50%) rotate(360deg); }
    }
    .gr-hero-circle-badge {
        animation: spinBadge 12s linear infinite;
    }
    .gr-hero-circle-badge:hover { animation-play-state: paused; }


    /* ── MARQUEE ── */
    .gr-marquee {
        background: #991b1b;
        border-top: none;
        border-bottom: none;
        overflow: hidden;
        padding: 10px 0;
        position: relative;
        margin-top: 4px;
    }
    .gr-marquee-track {
        display: flex;
        width: max-content;
        animation: gr-marquee-scroll 25s linear infinite;
    }
    .gr-marquee-content {
        display: flex;
        align-items: center;
        flex-shrink: 0;
    }
    .gr-marquee-item {
        font-family: var(--font-heading);
        font-size: 14px;
        font-style: normal;
        color: #fff;
        white-space: nowrap;
        padding: 0 24px;
        letter-spacing: 2px;
    }
    .gr-marquee-dot {
        color: rgba(255,255,255,0.5);
        font-size: 8px;
        padding: 0 4px;
        flex-shrink: 0;
    }

    /* ── WARDROBE CARDS ── */
    .gr-wardrobe-card {
        border: 1px solid var(--border) !important;
        transition: all 0.3s cubic-bezier(0.16,1,0.3,1) !important;
        background: var(--surface) !important;
    }
    .gr-wardrobe-card:hover {
        transform: translate(-4px, -4px) !important;
        box-shadow: 4px 4px 0px var(--primary) !important;
    }
    .gr-wardrobe-card img {
        transition: transform 0.7s cubic-bezier(0.16,1,0.3,1) !important;
    }
    .gr-wardrobe-card:hover img { transform: scale(1.04) !important; }

    /* ── PRODUCT CARDS ── */
    .gr-product-card {
        border: 1px solid var(--border) !important;
        padding: 8px 8px 16px 8px !important;
        background: var(--surface) !important;
        transition: all 0.25s cubic-bezier(0.16,1,0.3,1) !important;
    }
    .gr-product-card:hover {
        border-color: var(--primary) !important;
        transform: translateY(-3px) !important;
        box-shadow: 0 12px 32px rgba(0,0,0,0.4) !important;
    }
    .gr-product-card-img {
        overflow: hidden;
        position: relative;
        aspect-ratio: 3/4 !important;
        border: 1px solid rgba(153,27,27,0.25) !important;
    }
    .gr-product-card-img img {
        transition: transform 0.8s cubic-bezier(0.16,1,0.3,1);
    }
    .gr-product-card:hover .gr-product-card-img img { transform: scale(1.05); }
    .gr-product-view-btn {
        transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
        opacity: 0;
        transform: translateY(6px);
        position: absolute;
        bottom: 12px;
        left: 12px;
        padding: 6px 14px;
        font-family: var(--font);
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        background: rgba(0,0,0,0.85);
        color: var(--text);
        border: 1px solid rgba(255,255,255,0.15);
        z-index: 2;
    }
    .gr-product-card:hover .gr-product-view-btn {
        opacity: 1;
        transform: translateY(0);
    }

    /* ── EDITORIAL SECTION ── */
    .gr-editorial {
        padding: 80px 0;
        background: #0a0a0a;
        position: relative;
        overflow: hidden;
    }
    .gr-editorial::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(rgba(153,27,27,0.06) 1px, transparent 1px);
        background-size: 32px 32px;
        pointer-events: none;
    }
    .gr-editorial-inner {
        max-width: var(--max-width);
        margin: 0 auto;
        padding: 0 24px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
        position: relative;
        z-index: 1;
    }
    .gr-editorial-images {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        align-items: end;
    }
    .gr-editorial-img-1, .gr-editorial-img-2 {
        overflow: hidden;
        border: 1px solid #1e1e1e;
    }
    .gr-editorial-img-1 {
        aspect-ratio: 3/4;
        margin-bottom: 32px;
    }
    .gr-editorial-img-2 {
        aspect-ratio: 3/5;
    }
    .gr-editorial-img-1 img, .gr-editorial-img-2 img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s cubic-bezier(0.16,1,0.3,1);
    }
    .gr-editorial-img-1:hover img,
    .gr-editorial-img-2:hover img { transform: scale(1.04); }
    .gr-editorial-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 13px 26px;
        border: 1px solid #3a3a3a;
        background: transparent;
        color: var(--text);
        font-family: var(--font);
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        cursor: pointer;
        transition: all 0.25s ease;
        text-decoration: none;
        margin-top: 28px;
    }
    .gr-editorial-btn:hover {
        background: #fff;
        color: #000;
        border-color: #fff;
    }

    /* ── OUTFIT BUILDER CTA BOX ── */
    .gr-outfit-cta {
        max-width: var(--max-width);
        margin: 64px auto 0;
        padding: 0 24px;
        box-sizing: border-box;
    }
    .gr-outfit-cta-inner {
        position: relative;
        background: #0e0e0e;
        border: 1px solid #222;
        padding: 56px 60px;
        display: grid;
        grid-template-columns: 1fr auto;
        align-items: center;
        gap: 48px;
        overflow: hidden;
    }
    .gr-outfit-cta-inner::before {
        content: 'OUTFIT\ABUILDER';
        white-space: pre;
        position: absolute;
        right: -40px;
        top: 50%;
        transform: translateY(-50%);
        font-family: var(--font-heading);
        font-size: 180px;
        line-height: 0.85;
        color: rgba(255,255,255,0.025);
        pointer-events: none;
        user-select: none;
        letter-spacing: -4px;
    }
    .gr-outfit-cta-label {
        font-family: var(--font);
        font-size: 9px;
        font-weight: 700;
        color: #991b1b;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .gr-outfit-cta-label::before {
        content: '';
        display: inline-block;
        width: 20px;
        height: 1px;
        background: #991b1b;
    }
    .gr-outfit-cta-title {
        font-family: var(--font-heading);
        font-size: clamp(36px, 4vw, 60px);
        font-weight: 400;
        color: #f0ece3;
        line-height: 1.0;
        margin-bottom: 16px;
        letter-spacing: 1px;
    }
    .gr-outfit-cta-title span {
        background: #991b1b;
        color: #fff;
        padding: 0 10px;
        display: inline-block;
    }
    .gr-outfit-cta-body {
        font-family: var(--font-serif);
        font-style: italic;
        font-size: 14px;
        color: #666;
        line-height: 1.7;
        margin-bottom: 0;
        max-width: 480px;
    }
    .gr-outfit-cta-btn {
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 6px;
        padding: 24px 36px;
        background: #991b1b;
        color: #fff;
        font-family: var(--font);
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.14em;
        text-decoration: none;
        transition: all 0.25s ease;
        border: 1px solid transparent;
        position: relative;
        z-index: 1;
        white-space: nowrap;
    }
    .gr-outfit-cta-btn:hover {
        background: transparent;
        color: #991b1b;
        border-color: #991b1b;
    }
    .gr-outfit-cta-btn-icon {
        font-size: 22px;
        display: block;
    }

    /* ── TRUST BADGES ── */
    .gr-trust-footer {
        background: #0a0a0a;
        border-top: 1px solid #1e1e1e;
        border-bottom: 1px solid #1e1e1e;
        padding: 60px 0;
        margin-top: 64px;
    }
    .gr-trust-grid {
        max-width: var(--max-width);
        margin: 0 auto;
        padding: 0 24px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0;
    }
    .gr-trust-card {
        padding: 28px 24px;
        text-align: center;
        border-right: 1px solid #1e1e1e;
        transition: all 0.25s ease;
        position: relative;
    }
    .gr-trust-card:last-child { border-right: none; }
    .gr-trust-card:hover { background: #111; }
    .gr-trust-icon {
        width: 44px;
        height: 44px;
        background: rgba(153,27,27,0.12);
        border: 1px solid rgba(153,27,27,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        transition: all 0.3s ease;
    }
    .gr-trust-card:hover .gr-trust-icon {
        background: #991b1b;
        border-color: #991b1b;
    }
    .gr-trust-icon i { font-size: 16px; color: #991b1b; transition: color 0.3s; }
    .gr-trust-card:hover .gr-trust-icon i { color: #fff; }
    .gr-trust-card h3 {
        font-family: var(--font-heading);
        font-size: 15px;
        color: #e8e8e8;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .gr-trust-card p {
        font-family: var(--font);
        font-size: 11px;
        color: #555;
        line-height: 1.7;
    }

    /* ── INSTAGRAM STRIP ── */
    .gr-insta-strip {
        padding: 64px 0 72px;
        background: #060606;
        border-top: 1px solid #111;
    }
    .gr-insta-header {
        max-width: var(--max-width);
        margin: 0 auto 32px;
        padding: 0 24px;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
    }
    .gr-insta-title {
        font-family: var(--font-heading);
        font-size: clamp(28px, 4vw, 48px);
        color: #f0ece3;
        letter-spacing: 1px;
        line-height: 1;
    }
    .gr-insta-handle {
        font-family: var(--font);
        font-size: 11px;
        color: #555;
        letter-spacing: 0.06em;
    }
    .gr-insta-handle a { color: #991b1b; }
    .gr-insta-grid {
        max-width: var(--max-width);
        margin: 0 auto;
        padding: 0 24px;
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 4px;
    }
    .gr-insta-tile {
        aspect-ratio: 1;
        background: #111;
        border: 1px solid #1a1a1a;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .gr-insta-tile-inner {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0,0,0,0.5);
        opacity: 0;
        transition: opacity 0.25s ease;
        z-index: 2;
    }
    .gr-insta-tile:hover .gr-insta-tile-inner { opacity: 1; }
    .gr-insta-tile-icon { font-size: 24px; color: #fff; }
    .gr-insta-tile-label {
        font-family: var(--font-heading);
        font-size: 120px;
        color: rgba(255,255,255,0.04);
        letter-spacing: -4px;
        position: absolute;
        pointer-events: none;
        user-select: none;
        line-height: 1;
    }

    /* ── ANIMATIONS ── */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(24px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .gr-hero-panel > * {
        animation: fadeInUp 0.8s cubic-bezier(0.16,1,0.3,1) forwards;
        opacity: 0;
    }
    .gr-hero-panel .gr-hero-text > .gr-hero-label { animation-delay: 0.1s; }
    .gr-hero-panel .gr-hero-text > .gr-hero-heading { animation-delay: 0.25s; }
    .gr-hero-panel .gr-hero-text > .gr-hero-subtitle { animation-delay: 0.4s; }
    .gr-hero-panel .gr-hero-text > .gr-hero-btns { animation-delay: 0.55s; }
    .gr-hero-panel .gr-hero-meta-strip { animation-delay: 0.7s; }

    /* ── MOBILE RESPONSIVE ── */
    @media (max-width: 768px) {
        .gr-hero {
            grid-template-columns: 1fr !important;
            margin: 0 !important;
            padding: 0 !important;
            min-height: auto !important;
            gap: 4px !important;
        }
        .gr-hero-panel {
            padding: 36px 24px;
            box-shadow: none;
        }
        .gr-hero-panel::after { font-size: 160px; }
        .gr-hero-images {
            min-height: 360px;
            grid-template-rows: 1fr 1fr;
        }
        .gr-hero-circle-badge { display: none; }
        .gr-trust-grid { grid-template-columns: 1fr 1fr; }
        .gr-trust-card { border-right: none; border-bottom: 1px solid #1e1e1e; }
        .gr-trust-card:last-child, .gr-trust-card:nth-child(2n) { border-right: none; }
        .gr-editorial-inner { grid-template-columns: 1fr; gap: 40px; }
        .gr-editorial-images { grid-template-columns: 1fr 1fr; }
        .gr-editorial-img-1 { margin-bottom: 0; }
        .gr-outfit-cta-inner {
            grid-template-columns: 1fr;
            padding: 40px 24px;
            gap: 32px;
        }
        .gr-outfit-cta-inner::before { display: none; }
        .gr-outfit-cta-btn { width: 100%; text-align: center; }
        .gr-insta-grid { grid-template-columns: repeat(3, 1fr); }
        .gr-hero-meta-strip { gap: 16px; }
        .gr-wardrobe-grid {
            grid-template-columns: 1fr 1fr !important;
        }
        .gr-wardrobe-card-tall {
            grid-row: 1 !important;
            grid-column: 1 / -1 !important;
            min-height: 240px !important;
        }
    }
</style>

    {{-- ─── HERO ─────────────────────────────────────────────── --}}
    @php
        $activeCarousels = \App\Models\Carousel::where('is_active', true)->latest()->take(2)->get();
        $heroImg1 = $activeCarousels->count() > 0 && $activeCarousels[0]->image_path
            ? asset('storage/' . $activeCarousels[0]->image_path)
            : asset('assets/images/hero1.jpg');
        $heroImg2 = $activeCarousels->count() > 1 && $activeCarousels[1]->image_path
            ? asset('storage/' . $activeCarousels[1]->image_path)
            : asset('assets/images/hero2.jpg');
        $heroTitle = $activeCarousels->count() > 0 && $activeCarousels[0]->title
            ? $activeCarousels[0]->title
            : "MEN'S<br>CLOTHING<br><em>store</em>";
        $heroSubtitle = $activeCarousels->count() > 0 && $activeCarousels[0]->description
            ? $activeCarousels[0]->description
            : "Premium menswear. Made for the road. Heavy fabrics, honest stitching.";
        $heroBtnText = $activeCarousels->count() > 0 && $activeCarousels[0]->button_text
            ? $activeCarousels[0]->button_text
            : "SHOP THE DROP";
        $heroBtnLink = $activeCarousels->count() > 0 && $activeCarousels[0]->button_link
            ? $activeCarousels[0]->button_link
            : route('products.all');
    @endphp

    {{-- Slideshow preloader script --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const slideshows = document.querySelectorAll('.hover-slideshow');
        slideshows.forEach(img => {
            let images = [];
            try { images = JSON.parse(img.getAttribute('data-images')); } catch(e){}
            if (images.length > 1) {
                let interval, currentIndex = 0;
                const card = img.closest('.gr-product-card');
                if (!card) return;
                images.forEach(src => { const p = new Image(); p.src = src; });
                card.addEventListener('mouseenter', () => {
                    interval = setInterval(() => {
                        currentIndex = (currentIndex + 1) % images.length;
                        img.src = images[currentIndex];
                    }, 650);
                });
                card.addEventListener('mouseleave', () => {
                    clearInterval(interval);
                    currentIndex = 0;
                    img.src = images[0];
                });
            }
        });
    });
    </script>

    <section class="gr-hero">
        {{-- ── LEFT PANEL ── --}}
        <div class="gr-hero-panel">
            <div class="gr-hero-text">
                <div class="gr-hero-label">FALL / WINTER '26 — VOL. III</div>
                <h1 class="gr-hero-heading">{!! $heroTitle !!}</h1>
                <p class="gr-hero-subtitle">{{ $heroSubtitle }}</p>
                <div class="gr-hero-btns">
                    <a href="{{ $heroBtnLink }}" class="gr-hero-btn-primary">
                        <span>{{ $heroBtnText }} →</span>
                    </a>
                    <a href="{{ route('outfit-builder') }}" class="gr-hero-btn-outline">
                        OUTFIT BUILDER
                    </a>
                </div>
            </div>
            <div class="gr-hero-meta-strip">
                <div class="gr-hero-meta-item">
                    <div class="gr-hero-meta-num">100+</div>
                    <div class="gr-hero-meta-label">Products</div>
                </div>
                <div class="gr-hero-meta-divider"></div>
                <div class="gr-hero-meta-item">
                    <div class="gr-hero-meta-num">5★</div>
                    <div class="gr-hero-meta-label">Rated</div>
                </div>
                <div class="gr-hero-meta-divider"></div>
                <div class="gr-hero-meta-item">
                    <div class="gr-hero-meta-num">7D</div>
                    <div class="gr-hero-meta-label">Returns</div>
                </div>
                <div class="gr-hero-meta-divider"></div>
                <div class="gr-hero-meta-item">
                    <div class="gr-hero-meta-num">CBE</div>
                    <div class="gr-hero-meta-label">Based</div>
                </div>
            </div>
        </div>

        {{-- ── RIGHT IMAGES ── --}}
        <div class="gr-hero-images">
            <div class="gr-hero-circle-badge">
                <span>NEW<br>DROP<br>•<br>LTD</span>
            </div>
            <div class="gr-hero-img-1" style="position:relative;">
                <img src="{{ $heroImg1 }}" alt="Editorial fashion shot" loading="eager">
                <div class="gr-hero-img-overlay"></div>
                <div class="gr-img-badge">
                    <div class="gr-img-badge-dot"></div>
                    <div class="gr-img-badge-text">New Season Drop</div>
                </div>
            </div>
            <div class="gr-hero-img-2" style="position:relative;">
                <img src="{{ $heroImg2 }}" alt="Street style fashion" loading="eager">
                <div class="gr-hero-img-overlay"></div>
                <div class="gr-img-badge" style="bottom:16px; right:16px; left:auto;">
                    <div class="gr-img-badge-text">Limited Stock</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── MARQUEE TICKER ─────────────────────────────────────── --}}
    <div class="gr-marquee">
        <div class="gr-marquee-track">
            <div class="gr-marquee-content">
                <span class="gr-marquee-item">STREET WEAR</span>
                <span class="gr-marquee-dot">•</span>
                <span class="gr-marquee-item">VINTAGE STYLE</span>
                <span class="gr-marquee-dot">•</span>
                <span class="gr-marquee-item">CASUALS</span>
                <span class="gr-marquee-dot">•</span>
                <span class="gr-marquee-item">FORMALS</span>
                <span class="gr-marquee-dot">•</span>
                <span class="gr-marquee-item">DENIM</span>
                <span class="gr-marquee-dot">•</span>
                <span class="gr-marquee-item">OVERSIZED</span>
                <span class="gr-marquee-dot">•</span>
                <span class="gr-marquee-item">MADE IN INDIA</span>
                <span class="gr-marquee-dot">•</span>
            </div>
            <div class="gr-marquee-content" aria-hidden="true">
                <span class="gr-marquee-item">STREET WEAR</span>
                <span class="gr-marquee-dot">•</span>
                <span class="gr-marquee-item">VINTAGE STYLE</span>
                <span class="gr-marquee-dot">•</span>
                <span class="gr-marquee-item">CASUALS</span>
                <span class="gr-marquee-dot">•</span>
                <span class="gr-marquee-item">FORMALS</span>
                <span class="gr-marquee-dot">•</span>
                <span class="gr-marquee-item">DENIM</span>
                <span class="gr-marquee-dot">•</span>
                <span class="gr-marquee-item">OVERSIZED</span>
                <span class="gr-marquee-dot">•</span>
                <span class="gr-marquee-item">MADE IN INDIA</span>
                <span class="gr-marquee-dot">•</span>
            </div>
        </div>
    </div>


    {{-- ─── THE WARDROBE ─────────────────────────────────────── --}}
    @php
        $wardrobeImgs = [
            asset('assets/images/official-logo.jpg'),
            asset('assets/images/logo.png'),
        ];
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
            {{-- Tall card --}}
            @if($categories->count() > 0)
                <a href="{{ url($categories->first()->slug) }}" class="gr-wardrobe-card gr-wardrobe-card-tall"
                    aria-label="Shop {{ $categories->first()->name }}">
                    <img src="{{ asset('storage/' . $categories->first()->image) }}"
                        onerror="this.src='{{ $wardrobeImgs[0] }}'"
                        alt="{{ $categories->first()->name }}" loading="lazy">
                    <div class="gr-wardrobe-overlay">
                        <div class="gr-wardrobe-title">{{ strtoupper($categories->first()->name) }}</div>
                        <span class="gr-wardrobe-link">SHOP {{ strtoupper($categories->first()->name) }} →</span>
                    </div>
                </a>
            @endif

            @foreach($categories->skip(1)->take(2) as $i => $cat)
                <a href="{{ url($cat->slug) }}" class="gr-wardrobe-card gr-wardrobe-card-normal"
                    aria-label="Shop {{ $cat->name }}">
                    <img src="{{ asset('storage/' . $cat->image) }}"
                        onerror="this.src='{{ $wardrobeImgs[$i % 2] }}'"
                        alt="{{ $cat->name }}" loading="lazy">
                    <div class="gr-wardrobe-overlay">
                        <div class="gr-wardrobe-title">{{ strtoupper($cat->name) }}</div>
                        <span class="gr-wardrobe-link">SHOP {{ strtoupper($cat->name) }} →</span>
                    </div>
                </a>
            @endforeach

            @foreach($categories->skip(3)->take(2) as $i => $cat)
                <a href="{{ url($cat->slug) }}" class="gr-wardrobe-card gr-wardrobe-card-normal"
                    aria-label="Shop {{ $cat->name }}">
                    <img src="{{ asset('storage/' . $cat->image) }}"
                        onerror="this.src='{{ $wardrobeImgs[$i % 2] }}'"
                        alt="{{ $cat->name }}" loading="lazy">
                    <div class="gr-wardrobe-overlay">
                        <div class="gr-wardrobe-title">{{ strtoupper($cat->name) }}</div>
                        <span class="gr-wardrobe-link">SHOP {{ strtoupper($cat->name) }} →</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>


    {{-- ─── FRESH OFF THE PRESS ─────────────────────────────── --}}
    @php
        $phs = array_fill(0, 8, asset('assets/images/logo.png'));
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
                            @php $inWishlist = auth()->user()->wishlistItems->contains('product_id', $product->product_id); @endphp
                            <form action="{{ route('wishlist.toggle', $product->product_id) }}" method="POST"
                                style="position:absolute;top:10px;right:10px;z-index:5;margin:0;">
                                @csrf
                                <button type="submit" onclick="event.preventDefault();this.closest('form').submit();"
                                    class="o-product-wishlist" style="display:flex;align-items:center;justify-content:center;"
                                    aria-label="Toggle Wishlist">
                                    <i class="{{ $inWishlist ? 'fas' : 'far' }} fa-heart"
                                        style="color:{{ $inWishlist ? 'var(--accent)' : 'inherit' }};"></i>
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
                        $imageUrls = array_map(fn($img) => asset('storage/' . $img), array_values($validImages));
                    @endphp
                    <img src="{{ asset('storage/' . $product->image) }}"
                        onerror="this.src='{{ $phs[$i % 8] }}'"
                        data-images='@json($imageUrls)'
                        class="hover-slideshow"
                        alt="{{ $product->name }}" loading="lazy">
                    <span class="gr-product-view-btn">QUICK VIEW →</span>
                </div>
                <div class="gr-product-card-body" style="padding:12px 6px 4px;">
                    <div style="font-family:var(--font);font-size:8px;color:var(--text-muted);text-transform:uppercase;margin-bottom:5px;letter-spacing:0.08em;display:flex;justify-content:space-between;">
                        <span>ITEM-0{{ $product->id }}</span>
                        <span>{{ $product->category->name ?? 'MENSWEAR' }}</span>
                    </div>
                    <div class="gr-product-name" style="font-family:var(--font-heading);font-weight:400;font-size:17px;margin-bottom:6px;color:var(--text);letter-spacing:0.5px;">
                        {{ strtoupper($product->name) }}
                    </div>
                    <div class="gr-product-meta" style="margin-top:8px;display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:8px;font-weight:700;color:var(--text-muted);letter-spacing:0.08em;text-transform:uppercase;">
                            @if($product->sizes && $product->sizes->count())
                                {{ $product->sizes->pluck('size')->join(' / ') }}
                            @else
                                S / M / L / XL
                            @endif
                        </span>
                        <span class="gr-product-price" style="font-family:var(--font);font-weight:700;color:var(--accent);font-size:14px;">
                            ₹{{ number_format($product->price ?? 0) }}
                        </span>
                    </div>
                </div>
            </a>
        @empty
            <div style="grid-column:1/-1;text-align:center;padding:80px 20px;">
                <p style="color:var(--text-muted);font-family:var(--font-serif);font-style:italic;font-size:15px;">
                    Fresh drops landing soon. Check back later.
                </p>
            </div>
        @endforelse
    </div>


    {{-- ─── EDITORIAL / FEATURED PRODUCT ───────────────────── --}}
    @php
        $featuredProduct = \App\Models\FeaturedProduct::where('is_active', true)->latest()->first();
        $featTagline     = $featuredProduct->tagline ?? "FIELD NOTES — VOL. III";
        $featTitle       = $featuredProduct->title ?? "CUT FROM<br><em>honest</em> CLOTH.";
        $featDesc        = $featuredProduct->description ?? "We build clothes for men who don't chase trends. Heavy fabrics. Honest stitching. Pieces that earn their fade.\n\nEvery piece in the GET READY catalog is made in small batches, washed twice, and tested by people who actually wear them. That's the whole story.";
        $featBtnText     = $featuredProduct->button_text ?? "READ THE MANIFESTO →";
        $featBtnLink     = $featuredProduct->button_link ?? route('manifesto');
        $featImg1        = $featuredProduct && $featuredProduct->image_path
            ? asset('storage/' . $featuredProduct->image_path)
            : asset('assets/images/official-logo.jpg');
        $featImg2        = asset('assets/images/logo.png');
    @endphp

    <section class="gr-editorial">
        <div class="gr-editorial-inner">
            <div class="gr-editorial-text">
                <div class="gr-editorial-label">{{ $featTagline }}</div>
                <h2 class="gr-editorial-heading">{!! $featTitle !!}</h2>
                <div class="gr-editorial-body" style="white-space:pre-line;">{{ $featDesc }}</div>

                @if($featuredProduct && $featuredProduct->discounted_price > 0)
                    <div style="margin-top:20px; margin-bottom:8px;">
                        <span style="font-family:var(--font-heading);font-size:28px;color:var(--accent);">
                            ₹{{ number_format($featuredProduct->discounted_price) }}
                        </span>
                        @if($featuredProduct->original_price > $featuredProduct->discounted_price)
                            <span style="text-decoration:line-through;color:var(--text-muted);font-size:14px;margin-left:10px;">
                                ₹{{ number_format($featuredProduct->original_price) }}
                            </span>
                        @endif
                    </div>
                @endif

                <a href="{{ $featBtnLink }}" class="gr-editorial-btn">{{ $featBtnText }}</a>
            </div>
            <div class="gr-editorial-images">
                <div class="gr-editorial-img-1">
                    <img src="{{ $featImg1 }}" alt="Featured Product" loading="lazy">
                </div>
                <div class="gr-editorial-img-2">
                    <img src="{{ $featImg2 }}" alt="Vintage clothing" loading="lazy">
                </div>
            </div>
        </div>
    </section>


    {{-- ─── OUTFIT BUILDER CTA ───────────────────────────────── --}}
    <div class="gr-outfit-cta">
        <div class="gr-outfit-cta-inner">
            <div>
                <div class="gr-outfit-cta-label">INTERACTIVE TOOL — EXCLUSIVE</div>
                <h2 class="gr-outfit-cta-title">
                    SPIN THE <span>OUTFIT</span><br>WHEEL.
                </h2>
                <p class="gr-outfit-cta-body">
                    Can't decide? Let algorithm-driven chance dress you. Our interactive Outfit Builder
                    generates a full vintage, editorial combination in 3 seconds.
                </p>
            </div>
            <a href="{{ route('outfit-builder') }}" class="gr-outfit-cta-btn">
                <span class="gr-outfit-cta-btn-icon">⚙</span>
                TRY THE BUILDER →
            </a>
        </div>
    </div>


    {{-- ─── TRUST BADGES ─────────────────────────────────────── --}}
    <section class="gr-trust-footer">
        <div class="gr-trust-grid">
            <div class="gr-trust-card">
                <div class="gr-trust-icon"><i class="fas fa-truck-moving"></i></div>
                <h3>Fast Delivery</h3>
                <p>Free shipping on orders above ₹999. Dispatched within 24–48 hrs.</p>
            </div>
            <div class="gr-trust-card">
                <div class="gr-trust-icon"><i class="fas fa-recycle"></i></div>
                <h3>Small Batch</h3>
                <p>Limited release runs made responsibly with organic, extra-long staple cotton.</p>
            </div>
            <div class="gr-trust-card">
                <div class="gr-trust-icon"><i class="fas fa-undo-alt"></i></div>
                <h3>7-Day Returns</h3>
                <p>Return or exchange within 7 days of delivery. Simplified process.</p>
            </div>
            <div class="gr-trust-card">
                <div class="gr-trust-icon"><i class="fab fa-whatsapp"></i></div>
                <h3>WhatsApp Support</h3>
                <p>Instant support on WhatsApp. We respond within minutes.</p>
            </div>
        </div>
    </section>


    {{-- ─── INSTAGRAM STRIP ──────────────────────────────────── --}}
    <section class="gr-insta-strip">
        <div class="gr-insta-header">
            <div>
                <div style="font-family:var(--font);font-size:9px;color:#555;letter-spacing:0.12em;text-transform:uppercase;margin-bottom:10px;">INDEX — 03</div>
                <div class="gr-insta-title">FOLLOW THE FEED</div>
            </div>
            <div class="gr-insta-handle">
                <a href="https://www.instagram.com/_getreadyyyy" target="_blank" rel="noopener">@_getreadyyyy</a>
                &nbsp;on Instagram
            </div>
        </div>
        <div class="gr-insta-grid">
            @for($t = 1; $t <= 5; $t++)
            <a href="https://www.instagram.com/_getreadyyyy" target="_blank" rel="noopener"
               class="gr-insta-tile" aria-label="Instagram Post {{ $t }}">
                <span class="gr-insta-tile-label">IG</span>
                <div class="gr-insta-tile-inner">
                    <i class="fab fa-instagram gr-insta-tile-icon"></i>
                </div>
            </a>
            @endfor
        </div>
        <div style="text-align:center;margin-top:28px;">
            <a href="https://www.instagram.com/_getreadyyyy" target="_blank" rel="noopener"
               style="font-family:var(--font);font-size:10px;font-weight:700;color:#555;letter-spacing:0.12em;text-transform:uppercase;border-bottom:1px solid #333;padding-bottom:2px;transition:color 0.2s,border-color 0.2s;"
               onmouseover="this.style.color='#e8e8e8';this.style.borderColor='#e8e8e8';"
               onmouseout="this.style.color='#555';this.style.borderColor='#333';">
                VIEW ALL ON INSTAGRAM →
            </a>
        </div>
    </section>

@endsection