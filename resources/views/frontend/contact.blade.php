@extends('layouts.front')
@section('title', 'Contact Us | GET READY')

@section('content')

<section class="gr-hero" style="min-height: 400px; padding: 60px 24px;">
    <div class="gr-hero-text" style="padding-top: 40px;">
        <div class="gr-hero-label">DISPATCH</div>
        <h1 class="gr-hero-heading" style="font-size: clamp(48px, 6vw, 80px); margin-bottom: 24px;">
            GET IN<br>
            <em>touch</em>.
        </h1>
        <p class="gr-hero-subtitle" style="font-size: 18px; max-width: 500px;">
            Questions about an order, fit advice, or just want to talk denim? We're on the line.
        </p>
    </div>
    <div class="gr-hero-images">
        <div class="gr-hero-tag">SUPPORT</div>
        <div class="gr-hero-img-1" style="width: 70%; height: 80%; top: 10%; right: 10%;">
            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=800&q=80" 
                 alt="Contact Us" loading="eager" style="filter: grayscale(100%);">
        </div>
    </div>
</section>

<div class="gr-wardrobe" style="padding: 60px 24px 100px;">
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:40px; max-width:1000px; margin:0 auto;">
        
        {{-- Contact Info Card --}}
        <div style="background:var(--white); border:1px solid var(--text); padding:32px;">
            <h2 style="font-family:var(--font-heading); font-size:32px; font-weight:700; margin-bottom:24px; padding-bottom:12px; border-bottom:1px solid var(--text);">HQ COMMAND</h2>
            
            <div style="display:flex; flex-direction:column; gap:32px; font-family: var(--font);">
                <div>
                    <strong style="display:block; font-size:12px; color:var(--text); margin-bottom:8px; text-transform: uppercase; letter-spacing: 0.1em;">Direct Line</strong>
                    <a href="mailto:tamilkumaran1672@gmail.com" style="font-size:16px; color:var(--accent); text-decoration:none; display:block; margin-bottom:4px;">tamilkumaran1672@gmail.com</a>
                    <p style="font-size:11px; color:var(--text-muted); font-style: italic;">Dispatch guaranteed within 24 hours.</p>
                </div>

                <div>
                    <strong style="display:block; font-size:12px; color:var(--text); margin-bottom:8px; text-transform: uppercase; letter-spacing: 0.1em;">Voice</strong>
                    <a href="tel:+919080253885" style="font-size:16px; color:var(--text); text-decoration:none; display:block; margin-bottom:4px;">+91 9080253885</a>
                    <p style="font-size:11px; color:var(--text-muted); font-style: italic;">Mon-Fri 09:00 — 18:00 IST.</p>
                </div>

                <div>
                    <strong style="display:block; font-size:12px; color:var(--text); margin-bottom:8px; text-transform: uppercase; letter-spacing: 0.1em;">Location</strong>
                    <p style="font-size:14px; color:var(--text-secondary); line-height:1.6;">
                        104 Industrial Way<br>
                        Garment District, NY 10001<br>
                        United States
                    </p>
                </div>
            </div>
        </div>

        {{-- Form Area --}}
        <div style="background:var(--bg); border:1px solid var(--text); padding:32px;">
            <h2 style="font-family:var(--font-heading); font-size:32px; font-weight:700; margin-bottom:24px;">TRANSMIT</h2>
            
            <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Message dispatched. We will review and respond shortly.');">
                <div class="o-form-group">
                    <label for="name" class="o-label" style="font-family: var(--font); font-size: 10px; text-transform: uppercase; letter-spacing: 0.1em;">Operator Name</label>
                    <input type="text" id="name" name="name" class="o-input" required placeholder="John Doe" style="border: 1px solid var(--text); border-radius: 0; background: transparent;">
                </div>
                
                <div class="o-form-group">
                    <label for="email" class="o-label" style="font-family: var(--font); font-size: 10px; text-transform: uppercase; letter-spacing: 0.1em;">Comms Channel (Email)</label>
                    <input type="email" id="email" name="email" class="o-input" required placeholder="john@example.com" style="border: 1px solid var(--text); border-radius: 0; background: transparent;">
                </div>
                
                <div class="o-form-group">
                    <label for="subject" class="o-label" style="font-family: var(--font); font-size: 10px; text-transform: uppercase; letter-spacing: 0.1em;">Directive</label>
                    <div class="o-select-wrap">
                        <select id="subject" name="subject" class="o-input" required style="border: 1px solid var(--text); border-radius: 0; background: transparent;">
                            <option value="">Select a topic</option>
                            <option value="order">Order Tracking</option>
                            <option value="return">Returns / Repairs</option>
                            <option value="product">Product Intel</option>
                            <option value="other">Other Inquiry</option>
                        </select>
                    </div>
                </div>
                
                <div class="o-form-group">
                    <label for="message" class="o-label" style="font-family: var(--font); font-size: 10px; text-transform: uppercase; letter-spacing: 0.1em;">Message</label>
                    <textarea id="message" name="message" class="o-input" rows="5" required placeholder="Enter transmission..." style="border: 1px solid var(--text); border-radius: 0; background: transparent;"></textarea>
                </div>
                
                <button type="submit" class="gr-hero-btn-primary" style="width: 100%; justify-content: center; margin-top:24px;">SEND TRANSMISSION →</button>
            </form>
        </div>
        
    </div>
</div>

@endsection