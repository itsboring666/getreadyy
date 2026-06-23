@extends('layouts.front')
@section('title', 'Shipping & Returns | GET READY')

@section('content')

<section style="background: #0a0a0a; padding: 80px 24px 60px; border-bottom: 1px solid #222;">
    <div style="max-width: 1100px; margin: 0 auto;">
        <div style="font-size: 11px; letter-spacing: 3px; color: var(--accent); font-family: var(--font); font-weight: 700; margin-bottom: 16px; text-transform: uppercase;">Policies</div>
        <h1 style="font-family: var(--font-heading); font-size: clamp(44px, 6vw, 80px); line-height: 0.95; color: #fff;">
            SHIPPING<br><em style="color: var(--accent);">& RETURNS.</em>
        </h1>
    </div>
</section>

<section style="padding: 80px 24px 100px; background: var(--bg);">
    <div style="max-width: 800px; margin: 0 auto;">

        {{-- Shipping --}}
        <div style="margin-bottom: 60px;">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
                <div style="width: 48px; height: 48px; background: var(--accent); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fas fa-truck" style="color:#fff; font-size:18px;"></i>
                </div>
                <h2 style="font-family: var(--font-heading); font-size: 28px; color: var(--text); margin: 0;">DELIVERY</h2>
            </div>
            <div style="border-left: 3px solid var(--accent); padding-left: 24px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div style="background: var(--white); padding: 20px; border: 1px solid var(--border);">
                        <div style="font-family:var(--font-heading); font-size:14px; margin-bottom:8px; color:var(--text);">FREE SHIPPING</div>
                        <div style="font-family:var(--font); font-size:28px; font-weight:700; color:var(--accent); margin-bottom:4px;">₹999+</div>
                        <div style="font-family:var(--font); font-size:12px; color:var(--text-muted);">Free standard delivery on all orders above ₹999</div>
                    </div>
                    <div style="background: var(--white); padding: 20px; border: 1px solid var(--border);">
                        <div style="font-family:var(--font-heading); font-size:14px; margin-bottom:8px; color:var(--text);">STANDARD FEE</div>
                        <div style="font-family:var(--font); font-size:28px; font-weight:700; color:var(--text); margin-bottom:4px;">₹99</div>
                        <div style="font-family:var(--font); font-size:12px; color:var(--text-muted);">Flat fee for orders below ₹999</div>
                    </div>
                </div>
                <p style="font-family: var(--font); color: var(--text-secondary); line-height: 1.8; font-size: 14px;">
                    Orders are processed within <strong>1–2 business days</strong>. Standard delivery across India takes <strong>3–5 business days</strong> after dispatch. You will receive a tracking number once your order is shipped.
                </p>
            </div>
        </div>

        {{-- Returns --}}
        <div style="margin-bottom: 60px;">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
                <div style="width: 48px; height: 48px; background: var(--accent); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fas fa-undo" style="color:#fff; font-size:18px;"></i>
                </div>
                <h2 style="font-family: var(--font-heading); font-size: 28px; color: var(--text); margin: 0;">RETURNS</h2>
            </div>
            <div style="border-left: 3px solid var(--accent); padding-left: 24px;">
                <div style="background: var(--white); border: 1px solid var(--border); padding: 24px; margin-bottom: 20px; display: flex; align-items: center; gap: 20px;">
                    <div style="font-family: var(--font-heading); font-size: 48px; font-weight: 900; color: var(--accent); line-height: 1;">7</div>
                    <div>
                        <div style="font-family: var(--font-heading); font-size: 16px; color: var(--text); margin-bottom: 4px;">DAY RETURN WINDOW</div>
                        <div style="font-family: var(--font); font-size: 13px; color: var(--text-muted);">From the date of delivery</div>
                    </div>
                </div>
                <p style="font-family: var(--font); color: var(--text-secondary); line-height: 1.8; font-size: 14px; margin-bottom: 16px;">
                    We accept returns on <strong>unworn, unwashed items with original tags attached</strong> within <strong>7 days</strong> of delivery.
                </p>
                <p style="font-family: var(--font); color: var(--text-secondary); line-height: 1.8; font-size: 14px;">
                    To initiate a return, contact us via WhatsApp or email with your order number. A return shipping fee of ₹150 will be deducted from your refund.
                </p>
            </div>
        </div>

        {{-- Exchanges --}}
        <div style="margin-bottom: 60px;">
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
                <div style="width: 48px; height: 48px; background: var(--accent); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fas fa-exchange-alt" style="color:#fff; font-size:18px;"></i>
                </div>
                <h2 style="font-family: var(--font-heading); font-size: 28px; color: var(--text); margin: 0;">EXCHANGES</h2>
            </div>
            <div style="border-left: 3px solid var(--accent); padding-left: 24px;">
                <p style="font-family: var(--font); color: var(--text-secondary); line-height: 1.8; font-size: 14px;">
                    Need a different size? Place a new order for the correct size and return the original item for a refund. This ensures the new size doesn't go out of stock before your return is processed.
                </p>
            </div>
        </div>

        {{-- Contact CTA --}}
        <div style="background: #000; padding: 32px; text-align: center; border: 1px solid #222;">
            <h3 style="font-family: var(--font-heading); font-size: 24px; color: #fff; margin-bottom: 12px;">NEED HELP?</h3>
            <p style="font-family: var(--font); color: #666; font-size: 14px; margin-bottom: 24px;">Reach us anytime — we respond quickly.</p>
            <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                <a href="https://wa.me/919080253885" target="_blank"
                   style="display:inline-flex; align-items:center; gap:8px; background:#25D366; color:#fff; padding: 12px 24px; font-family:var(--font); font-size:13px; font-weight:700; text-decoration:none; letter-spacing:1px;">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
                <a href="{{ route('contact') }}"
                   style="display:inline-flex; align-items:center; gap:8px; background: var(--accent); color:#fff; padding: 12px 24px; font-family:var(--font); font-size:13px; font-weight:700; text-decoration:none; letter-spacing:1px;">
                    <i class="fas fa-envelope"></i> Email Us
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
