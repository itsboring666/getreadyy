{{-- GET READY — Editorial Footer --}}
<footer class="gr-footer">
    <div class="gr-footer-inner">
        {{-- Brand --}}
        <div>
            <div
                style="display: flex; align-items: center; justify-content: flex-start; height: 50px; width: 180px; overflow: hidden; margin-bottom: 15px; border-radius: 4px;">
                <img src="{{ asset('assets/images/official-logo.jpg') }}" alt="GET READY"
                    style="width: 100%; height: auto; object-fit: cover;">
            </div>
            <p class="gr-footer-tagline">Premium Menswear. EST. 2004.</p>
        </div>

        {{-- Shop --}}
        <div class="gr-footer-col">
            <h4>Shop</h4>
            <ul>
                <li><a href="{{ route('products.all') }}">All Items</a></li>
            </ul>
        </div>

        {{-- House --}}
        <div class="gr-footer-col">
            <h4>House</h4>
            <ul>
                <li><a href="{{ route('outfit-builder') }}">Outfit Builder</a></li>
                <li><a href="{{ route('about') }}">About Us</a></li>
                <li><a href="{{ route('manifesto') }}">Manifesto</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
                <li><a href="{{ route('shipping') }}">Shipping & Returns</a></li>
            </ul>
        </div>
    </div>

    <div class="gr-footer-bottom">
        <p>&copy; {{ date('Y') }} GET READY. All rights reserved.</p>
        <p>EST. 2004 — Premium Menswear</p>
    </div>
</footer>