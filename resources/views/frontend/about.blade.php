@extends('layouts.front')
@section('title', 'About Us | GET READY')

@section('content')

<section class="gr-hero" style="min-height: 400px; padding: 60px 24px;">
    <div class="gr-hero-text" style="padding-top: 40px;">
        <div class="gr-hero-label">HOUSE HISTORY</div>
        <h1 class="gr-hero-heading" style="font-size: clamp(48px, 6vw, 80px); margin-bottom: 24px;">
            ESTABLISHED<br>
            <em>in 2004</em>.
        </h1>
        <p class="gr-hero-subtitle" style="font-size: 18px; max-width: 500px;">
            A dedicated team of craftsmen, designers, and denim-heads building the wardrobe we always wanted but could never find.
        </p>
    </div>
    <div class="gr-hero-images">
        <div class="gr-hero-tag">ATELIER</div>
        <div class="gr-hero-img-1" style="width: 70%; height: 80%; top: 10%; right: 10%;">
            <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=800&q=80" 
                 alt="Our Store" loading="eager">
        </div>
    </div>
</section>

<section class="gr-editorial" style="padding: 60px 24px; background: var(--white);">
    <div style="max-width: 800px; margin: 0 auto; font-family: var(--font); color: var(--text-secondary); line-height: 1.8;">
        <h2 style="font-family: var(--font-heading); font-size: 32px; color: var(--text); margin-bottom: 24px;">THE WORKSHOP</h2>
        <p style="margin-bottom: 24px;">We operate out of a renovated warehouse where every prototype is cut, sewn, and tested before it ever sees production. We partner with heritage mills in Japan and the USA to source our fabrics, ensuring the highest quality raw materials.</p>
        
        <h2 style="font-family: var(--font-heading); font-size: 32px; color: var(--text); margin-bottom: 24px; margin-top: 48px;">SUSTAINABILITY</h2>
        <p style="margin-bottom: 24px;">The most sustainable garment is the one you don't have to replace. By over-engineering our clothing, we reduce the churn of fast fashion. We also offer free repairs on all our denim for the first year of ownership.</p>
    </div>
</section>

@endsection
