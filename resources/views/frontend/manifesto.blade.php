@extends('layouts.front')
@section('title', 'Our Manifesto | GET READY')

@section('content')

<section style="background: #000; min-height: 100vh; display: flex; align-items: center; padding: 100px 24px; position: relative; overflow: hidden;">
    {{-- Background text --}}
    <div style="position:absolute; font-family:var(--font-heading); font-size: 30vw; font-weight:900; color:rgba(255,255,255,0.02); top:50%; left:50%; transform:translate(-50%,-50%); white-space:nowrap; pointer-events:none; user-select:none;">GR</div>

    <div style="max-width: 800px; margin: 0 auto; text-align: center; position: relative;">
        <div style="font-size: 11px; letter-spacing: 4px; color: var(--accent); font-family: var(--font); font-weight: 700; margin-bottom: 20px; text-transform: uppercase;">The Manifesto</div>

        <h1 style="font-family: var(--font-heading); font-size: clamp(48px, 8vw, 96px); line-height: 0.9; color: #fff; margin-bottom: 48px;">
            DRESS LIKE<br>YOU <em style="color: var(--accent);">MEAN IT.</em>
        </h1>

        <div style="width: 60px; height: 3px; background: var(--accent); margin: 0 auto 48px;"></div>

        <p style="font-family: var(--font); font-size: 18px; color: #aaa; line-height: 1.8; margin-bottom: 32px; max-width: 600px; margin-left: auto; margin-right: auto;">
            We built GET READY because we believed clothing should be more than fabric — it should be a statement. Every morning when you get dressed, you're telling the world who you are.
        </p>
        <p style="font-family: var(--font); font-size: 15px; color: #666; line-height: 1.8; margin-bottom: 32px; max-width: 560px; margin-left: auto; margin-right: auto;">
            We don't chase trends. We build a wardrobe for men who know what they want — men who walk into a room and own it. Our pieces are picked with intention: clean cuts, quality fabric, and fits that actually work on real bodies.
        </p>
        <p style="font-family: var(--font); font-size: 15px; color: #666; line-height: 1.8; margin-bottom: 48px; max-width: 560px; margin-left: auto; margin-right: auto;">
            From Chengalpattu to everywhere else — GET READY is for the man who refuses to be overlooked. The one who shows up prepared. The one who's always... ready.
        </p>

        <div style="display: flex; gap: 2px; justify-content: center; margin-bottom: 60px;">
            <div style="background: var(--accent); color: #fff; padding: 16px 24px; font-family: var(--font-heading); font-size: 13px; letter-spacing: 2px;">QUALITY</div>
            <div style="background: #111; color: #fff; padding: 16px 24px; font-family: var(--font-heading); font-size: 13px; letter-spacing: 2px; border: 1px solid #333;">CONFIDENCE</div>
            <div style="background: var(--accent); color: #fff; padding: 16px 24px; font-family: var(--font-heading); font-size: 13px; letter-spacing: 2px;">STYLE</div>
        </div>

        <a href="{{ route('products.all') }}" class="gr-hero-btn-primary" style="display: inline-flex; font-size: 15px; padding: 16px 40px;">
            SHOP THE COLLECTION →
        </a>
    </div>
</section>

@endsection
