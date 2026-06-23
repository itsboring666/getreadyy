@extends('layouts.front')
@section('title', 'Contact Us | GET READY')

@section('content')

{{-- Hero --}}
<section style="background:#0a0a0a; padding: 80px 24px 60px; border-bottom: 1px solid #222;">
    <div style="max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;">
        <div>
            <div style="font-size: 11px; letter-spacing: 3px; color: var(--accent); font-family: var(--font); font-weight: 700; margin-bottom: 16px; text-transform: uppercase;">GET IN TOUCH</div>
            <h1 style="font-family: var(--font-heading); font-size: clamp(44px, 6vw, 80px); line-height: 1; margin-bottom: 20px; color: #fff;">
                WE'RE<br><em style="color: var(--accent);">HERE.</em>
            </h1>
            <p style="font-family: var(--font); font-size: 16px; color: #888; line-height: 1.7; max-width: 400px;">
                Questions about an order, size help, or just want to talk? We're available every day — reach us on WhatsApp, Instagram, or email.
            </p>
            {{-- Quick Links --}}
            <div style="display: flex; gap: 12px; margin-top: 32px; flex-wrap: wrap;">
                <a href="https://wa.me/919080253885" target="_blank" 
                   style="display:inline-flex; align-items:center; gap:8px; background:#25D366; color:#fff; padding: 10px 20px; font-family:var(--font); font-size:13px; font-weight:700; text-decoration:none; letter-spacing:1px;">
                    <i class="fab fa-whatsapp"></i> WHATSAPP US
                </a>
                <a href="https://www.instagram.com/_getreadyyyy?igsh=NXZlZDViaTZ2ODVl" target="_blank" 
                   style="display:inline-flex; align-items:center; gap:8px; background: linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); color:#fff; padding: 10px 20px; font-family:var(--font); font-size:13px; font-weight:700; text-decoration:none; letter-spacing:1px;">
                    <i class="fab fa-instagram"></i> INSTAGRAM
                </a>
            </div>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2px;">
            <img src="{{ asset('assets/images/carousel_1.jpg') }}" alt="Store" style="width:100%; aspect-ratio:1; object-fit:cover; filter:grayscale(80%);">
            <img src="{{ asset('assets/images/carousel_3.jpg') }}" alt="Store" style="width:100%; aspect-ratio:1; object-fit:cover; filter:grayscale(80%); margin-top: 30px;">
        </div>
    </div>
</section>

{{-- Contact Info + Form --}}
<section style="padding: 80px 24px 100px; background: var(--bg);">
    <div style="max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1.5fr; gap: 60px; align-items: start;">

        {{-- Left: Info --}}
        <div>
            <div style="font-size: 11px; letter-spacing: 3px; color: var(--accent); font-family: var(--font); font-weight: 700; margin-bottom: 16px; text-transform: uppercase;">Store Info</div>
            <h2 style="font-family: var(--font-heading); font-size: 32px; margin-bottom: 32px; color: var(--text);">GET READY HQ</h2>

            <div style="display: flex; flex-direction: column; gap: 28px; font-family: var(--font);">
                <div style="display: flex; gap: 16px; align-items: flex-start;">
                    <div style="width: 40px; height: 40px; background: var(--accent); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-map-marker-alt" style="color:#fff; font-size:16px;"></i>
                    </div>
                    <div>
                        <strong style="display:block; font-size:11px; letter-spacing:2px; color:var(--text); margin-bottom:6px; text-transform:uppercase;">Address</strong>
                        <p style="font-size:14px; color:var(--text-secondary); line-height:1.7; margin:0;">
                            No 19/1, TMS School (Opp) 2nd Mainroad<br>
                            2nd Cross Street, Railnagar,<br>
                            Maramalainagar, Chengalpattu<br>
                            Tamilnadu — 603203
                        </p>
                    </div>
                </div>

                <div style="display: flex; gap: 16px; align-items: flex-start;">
                    <div style="width: 40px; height: 40px; background: var(--accent); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-phone" style="color:#fff; font-size:16px;"></i>
                    </div>
                    <div>
                        <strong style="display:block; font-size:11px; letter-spacing:2px; color:var(--text); margin-bottom:6px; text-transform:uppercase;">Phone / WhatsApp</strong>
                        <a href="tel:+919080253885" style="font-size:16px; color:var(--text); text-decoration:none; display:block; font-weight:600;">+91 90802 53885</a>
                        <p style="font-size:11px; color:var(--text-muted); margin:4px 0 0; font-style:italic;">Mon – Sat, 9:00 AM – 8:00 PM IST</p>
                    </div>
                </div>

                <div style="display: flex; gap: 16px; align-items: flex-start;">
                    <div style="width: 40px; height: 40px; background: var(--accent); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-envelope" style="color:#fff; font-size:16px;"></i>
                    </div>
                    <div>
                        <strong style="display:block; font-size:11px; letter-spacing:2px; color:var(--text); margin-bottom:6px; text-transform:uppercase;">Email</strong>
                        <a href="mailto:tamilkumaran1672@gmail.com" style="font-size:14px; color:var(--accent); text-decoration:none;">tamilkumaran1672@gmail.com</a>
                        <p style="font-size:11px; color:var(--text-muted); margin:4px 0 0; font-style:italic;">Response within 24 hours</p>
                    </div>
                </div>

                <div style="display: flex; gap: 16px; align-items: flex-start;">
                    <div style="width: 40px; height: 40px; background: linear-gradient(45deg,#f09433,#cc2366); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fab fa-instagram" style="color:#fff; font-size:16px;"></i>
                    </div>
                    <div>
                        <strong style="display:block; font-size:11px; letter-spacing:2px; color:var(--text); margin-bottom:6px; text-transform:uppercase;">Instagram</strong>
                        <a href="https://www.instagram.com/_getreadyyyy?igsh=NXZlZDViaTZ2ODVl" target="_blank" style="font-size:14px; color:var(--accent); text-decoration:none;">@_getreadyyyy</a>
                        <p style="font-size:11px; color:var(--text-muted); margin:4px 0 0; font-style:italic;">DMs open for quick queries</p>
                    </div>
                </div>
            </div>

            {{-- Google Maps Embed --}}
            <div style="margin-top: 36px; border: 1px solid var(--border); overflow: hidden;">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3890.564!2d79.984!3d12.693!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a5257!2sRailnagar%2C+Chengalpattu!5e0!3m2!1sen!2sin!4v1"
                    width="100%" height="200" style="border:0; display:block; filter:grayscale(80%);" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>

        {{-- Right: Form --}}
        <div>
            <div style="font-size: 11px; letter-spacing: 3px; color: var(--accent); font-family: var(--font); font-weight: 700; margin-bottom: 16px; text-transform: uppercase;">Send a Message</div>
            <h2 style="font-family: var(--font-heading); font-size: 32px; margin-bottom: 32px; color: var(--text);">REACH OUT</h2>

            @if(session('success'))
                <div style="background: #052e16; border: 1px solid #16a34a; color: #4ade80; padding: 14px 20px; font-family: var(--font); font-size: 13px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #1c0707; border: 1px solid #dc2626; color: #f87171; padding: 14px 20px; font-family: var(--font); font-size: 13px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div class="o-form-group" style="margin-bottom: 0;">
                        <label for="name" class="o-label">Your Name *</label>
                        <input type="text" id="name" name="name" class="o-input @error('name') is-invalid @enderror" 
                               required placeholder="Tamilkumaran" value="{{ old('name') }}"
                               style="border: 1px solid {{ $errors->has('name') ? 'var(--accent)' : 'var(--border)' }}; border-radius: 0; background: var(--white);">
                        @error('name')<span style="color:var(--accent); font-size:11px;">{{ $message }}</span>@enderror
                    </div>
                    <div class="o-form-group" style="margin-bottom: 0;">
                        <label for="email" class="o-label">Email Address *</label>
                        <input type="email" id="email" name="email" class="o-input @error('email') is-invalid @enderror" 
                               required placeholder="you@gmail.com" value="{{ old('email') }}"
                               style="border: 1px solid {{ $errors->has('email') ? 'var(--accent)' : 'var(--border)' }}; border-radius: 0; background: var(--white);">
                        @error('email')<span style="color:var(--accent); font-size:11px;">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                    <div class="o-form-group" style="margin-bottom: 0;">
                        <label for="phone" class="o-label">Phone (Optional)</label>
                        <input type="tel" id="phone" name="phone" class="o-input" 
                               placeholder="+91 90802 53885" value="{{ old('phone') }}"
                               style="border: 1px solid var(--border); border-radius: 0; background: var(--white);">
                    </div>
                    <div class="o-form-group" style="margin-bottom: 0;">
                        <label for="subject" class="o-label">Subject *</label>
                        <div class="o-select-wrap">
                            <select id="subject" name="subject" class="o-input @error('subject') is-invalid @enderror" required
                                    style="border: 1px solid {{ $errors->has('subject') ? 'var(--accent)' : 'var(--border)' }}; border-radius: 0; background: var(--white);">
                                <option value="">Select a topic</option>
                                <option value="Order Tracking" {{ old('subject') === 'Order Tracking' ? 'selected' : '' }}>Order Tracking</option>
                                <option value="Returns / Exchange" {{ old('subject') === 'Returns / Exchange' ? 'selected' : '' }}>Returns / Exchange</option>
                                <option value="Product Query" {{ old('subject') === 'Product Query' ? 'selected' : '' }}>Product Query</option>
                                <option value="Sizing Help" {{ old('subject') === 'Sizing Help' ? 'selected' : '' }}>Sizing Help</option>
                                <option value="Other" {{ old('subject') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        @error('subject')<span style="color:var(--accent); font-size:11px;">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="o-form-group">
                    <label for="message" class="o-label">Your Message *</label>
                    <textarea id="message" name="message" class="o-input @error('message') is-invalid @enderror" rows="6" required 
                              placeholder="Hi, I wanted to ask about..." 
                              style="border: 1px solid {{ $errors->has('message') ? 'var(--accent)' : 'var(--border)' }}; border-radius: 0; background: var(--white); resize: vertical;">{{ old('message') }}</textarea>
                    @error('message')<span style="color:var(--accent); font-size:11px;">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="gr-hero-btn-primary" style="width: 100%; justify-content: center; margin-top: 8px; padding: 16px; font-size: 14px;">
                    SEND MESSAGE <i class="fas fa-paper-plane" style="margin-left:8px;"></i>
                </button>

                <p style="font-family:var(--font); font-size:11px; color:var(--text-muted); margin-top:12px; text-align:center;">
                    For fastest response, message us on <a href="https://wa.me/919080253885" target="_blank" style="color:#25D366;">WhatsApp</a> or <a href="https://www.instagram.com/_getreadyyyy" target="_blank" style="color:var(--accent);">Instagram</a>.
                </p>
            </form>
        </div>
    </div>
</section>

@endsection