{{-- GET READY — Footer --}}
<footer class="gr-footer">
    <div class="gr-footer-inner">
        {{-- Brand --}}
        <div>
            <div style="margin-bottom: 20px; display: inline-block; position: relative;">
                <img src="{{ asset('assets/images/official-logo.jpg') }}" alt="GET READY"
                    style="width: 140px; max-width: 100%; height: auto !important; object-fit: contain; display: block; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.6)); transition: transform 0.4s ease, filter 0.4s ease;" onmouseover="this.style.transform='scale(1.05)'; this.style.filter='drop-shadow(0 8px 16px rgba(0,0,0,0.9))';" onmouseout="this.style.transform='scale(1)'; this.style.filter='drop-shadow(0 4px 10px rgba(0,0,0,0.6))';">
            </div>
            <p class="gr-footer-tagline" style="max-width: 180px; line-height: 1.6;">Premium Men's Clothing.
                Chengalpattu, Tamil Nadu.</p>
            {{-- Social Icons --}}
            <div style="display: flex; gap: 10px; margin-top: 16px;">
                <a href="https://www.instagram.com/_getreadyyyy?igsh=NXZlZDViaTZ2ODVl" target="_blank"
                    style="width:36px; height:36px; background: linear-gradient(45deg,#f09433,#cc2366); border-radius:6px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:16px; text-decoration:none;"
                    title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://wa.me/919080253885" target="_blank"
                    style="width:36px; height:36px; background:#25D366; border-radius:6px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:16px; text-decoration:none;"
                    title="WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="mailto:tamilkumaran1672@gmail.com"
                    style="width:36px; height:36px; background:#ea4335; border-radius:6px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:16px; text-decoration:none;"
                    title="Email">
                    <i class="fas fa-envelope"></i>
                </a>
            </div>
        </div>

        {{-- Shop --}}
        <div class="gr-footer-col">
            <h4>Shop</h4>
            <ul>
                <li><a href="{{ route('products.all') }}">All Products</a></li>
                <li><a href="{{ route('outfit-builder') }}">Outfit Builder</a></li>
                @auth
                    <li><a href="{{ route('wishlist.index') }}">My Wishlist</a></li>
                    <li><a href="{{ route('orders.index') }}">My Orders</a></li>
                @endauth
            </ul>
        </div>

        {{-- House --}}
        <div class="gr-footer-col">
            <h4>Company</h4>
            <ul>
                <li><a href="{{ route('about') }}">About Us</a></li>
                <li><a href="{{ route('manifesto') }}">Our Manifesto</a></li>
                <li><a href="{{ route('contact') }}">Contact Us</a></li>
                <li><a href="{{ route('shipping') }}">Shipping & Returns</a></li>
                <li><a href="{{ route('developer') }}">Meet the Developer</a></li>
            </ul>
        </div>

        {{-- Contact --}}
        <div class="gr-footer-col">
            <h4>Contact</h4>
            <ul>
                <li>
                    <a href="mailto:tamilkumaran1672@gmail.com" style="display:flex; align-items:flex-start; gap:6px;">
                        <i class="fas fa-envelope" style="margin-top:3px; font-size:11px; flex-shrink:0;"></i>
                        tamilkumaran1672@gmail.com
                    </a>
                </li>
                <li>
                    <a href="tel:+919080253885" style="display:flex; align-items:center; gap:6px;">
                        <i class="fas fa-phone" style="font-size:11px; flex-shrink:0;"></i>
                        +91 90802 53885
                    </a>
                </li>
                <li>
                    <a href="https://www.instagram.com/_getreadyyyy?igsh=NXZlZDViaTZ2ODVl" target="_blank"
                        style="display:flex; align-items:center; gap:6px;">
                        <i class="fab fa-instagram" style="font-size:11px; flex-shrink:0;"></i>
                        @_getreadyyyy
                    </a>
                </li>
                <li style="margin-top: 8px;">
                    <span style="font-size:11px; color: #ffffff; line-height:1.6; display:block;">
                        <i class="fas fa-map-marker-alt" style="margin-right:4px; color: #ffffff;"></i>
                        Railnagar, Maramalainagar,<br>Chengalpattu, TN — 603203
                    </span>
                </li>
            </ul>
        </div>
    </div>

    <div class="gr-footer-bottom">
        <p>&copy; {{ date('Y') }} GET READY. All rights reserved.</p>
        <p style="display:flex; align-items:center; gap:8px;">
            <a href="{{ route('shipping') }}"
                style="color: var(--text-muted); text-decoration:none; font-size:11px;">Shipping & Returns</a>
            <span style="color:var(--border);">|</span>
            <a href="{{ route('contact') }}"
                style="color: var(--text-muted); text-decoration:none; font-size:11px;">Contact</a>
        </p>
    </div>
</footer>