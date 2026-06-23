@extends('layouts.front')
@section('title', 'About Us | GET READY')

@section('content')

{{-- Hero --}}
<section style="background: #0a0a0a; padding: 100px 24px 80px; position: relative; overflow: hidden; border-bottom: 1px solid #222;">
    <div style="position:absolute; top:0; right:0; width:50%; height:100%; opacity:0.15;">
        <img src="{{ asset('assets/images/carousel_3.jpg') }}" alt="" style="width:100%; height:100%; object-fit:cover; filter:grayscale(100%);">
    </div>
    <div style="max-width: 1100px; margin: 0 auto; position: relative;">
        <div style="font-size: 11px; letter-spacing: 3px; color: var(--accent); font-family: var(--font); font-weight: 700; margin-bottom: 16px; text-transform: uppercase;">WHO WE ARE</div>
        <h1 style="font-family: var(--font-heading); font-size: clamp(52px, 8vw, 110px); line-height: 0.9; color: #fff; max-width: 700px;">
            GET<br><em style="color: var(--accent);">READY.</em>
        </h1>
        <p style="font-family: var(--font); font-size: 18px; color: #888; max-width: 500px; line-height: 1.7; margin-top: 28px;">
            A men's clothing store built for the bold — rooted in Chengalpattu, dressed for the world.
        </p>
    </div>
</section>

{{-- Story --}}
<section style="padding: 80px 24px; background: var(--white); border-bottom: 1px solid var(--border);">
    <div style="max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center;">
        <div>
            <div style="font-size: 11px; letter-spacing: 3px; color: var(--accent); font-family: var(--font); font-weight: 700; margin-bottom: 16px; text-transform: uppercase;">Our Story</div>
            <h2 style="font-family: var(--font-heading); font-size: 40px; color: var(--text); margin-bottom: 24px; line-height: 1.1;">THE BRAND BEHIND THE NAME</h2>
            <p style="font-family: var(--font); color: var(--text-secondary); line-height: 1.8; margin-bottom: 20px; font-size: 15px;">
                GET READY was born from a simple idea — men in Tamil Nadu deserved clothing that matched their attitude. 
                Style that was bold, affordable, and made for real life.
            </p>
            <p style="font-family: var(--font); color: var(--text-secondary); line-height: 1.8; margin-bottom: 20px; font-size: 15px;">
                We started as a passion project and grew into a destination for men who take their look seriously. 
                From casual flannels to sharp outerwear, every piece we carry is picked to make you feel like the best version of yourself.
            </p>
            <p style="font-family: var(--font); color: var(--text-secondary); line-height: 1.8; font-size: 15px;">
                Our store is located in Railnagar, Maramalainagar — but our vision is far beyond. 
                We ship across India and serve customers who know that confidence starts with what you wear.
            </p>
        </div>
        <div style="position: relative;">
            <img src="{{ asset('assets/images/carousel_1.jpg') }}" alt="GET READY Store" 
                 style="width: 100%; aspect-ratio: 4/5; object-fit: cover; filter: grayscale(30%);">
            <div style="position: absolute; bottom: -20px; left: -20px; background: var(--accent); color: #fff; padding: 20px 24px; font-family: var(--font-heading); font-size: 18px; font-weight: 900;">
                MEN'S<br>CLOTHING
            </div>
        </div>
    </div>
</section>

{{-- Values --}}
<section style="padding: 80px 24px; background: var(--bg);">
    <div style="max-width: 1100px; margin: 0 auto;">
        <div style="text-align: center; margin-bottom: 60px;">
            <div style="font-size: 11px; letter-spacing: 3px; color: var(--accent); font-family: var(--font); font-weight: 700; margin-bottom: 12px; text-transform: uppercase;">What We Stand For</div>
            <h2 style="font-family: var(--font-heading); font-size: 40px; color: var(--text);">THE GET READY WAY</h2>
        </div>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px;">
            <div style="background: var(--white); padding: 40px 32px; border: 1px solid var(--border);">
                <div style="font-size: 32px; margin-bottom: 16px;">👔</div>
                <h3 style="font-family: var(--font-heading); font-size: 20px; margin-bottom: 12px; color: var(--text);">QUALITY FIRST</h3>
                <p style="font-family: var(--font); color: var(--text-secondary); line-height: 1.7; font-size: 14px;">Every item in our collection is hand-selected for quality, fit, and durability. We don't stock anything we wouldn't wear ourselves.</p>
            </div>
            <div style="background: var(--accent); padding: 40px 32px;">
                <div style="font-size: 32px; margin-bottom: 16px;">💪</div>
                <h3 style="font-family: var(--font-heading); font-size: 20px; margin-bottom: 12px; color: #fff;">MADE FOR REAL MEN</h3>
                <p style="font-family: var(--font); color: rgba(255,255,255,0.8); line-height: 1.7; font-size: 14px;">Our cuts are designed for real body types — not runway models. Clothes that fit well and feel great, all day long.</p>
            </div>
            <div style="background: var(--white); padding: 40px 32px; border: 1px solid var(--border);">
                <div style="font-size: 32px; margin-bottom: 16px;">🚀</div>
                <h3 style="font-family: var(--font-heading); font-size: 20px; margin-bottom: 12px; color: var(--text);">FAST DELIVERY</h3>
                <p style="font-family: var(--font); color: var(--text-secondary); line-height: 1.7; font-size: 14px;">Order today, shipped tomorrow. We process every order within 1-2 business days and deliver across India in 3-5 days.</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section style="background: #000; padding: 80px 24px; text-align: center;">
    <div style="font-family: var(--font-heading); font-size: clamp(36px, 5vw, 64px); color: #fff; margin-bottom: 20px; line-height: 1.1;">
        READY TO<br><span style="color: var(--accent);">LOOK THE PART?</span>
    </div>
    <p style="font-family: var(--font); color: #666; font-size: 16px; margin-bottom: 36px;">Explore our full collection and find your style.</p>
    <a href="{{ route('products.all') }}" class="gr-hero-btn-primary" style="display: inline-flex;">
        SHOP NOW →
    </a>
</section>

@endsection
