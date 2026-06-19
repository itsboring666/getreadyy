{{-- GET READY — Editorial Footer --}}
<footer class="gr-footer">
    <div class="gr-footer-inner">
        {{-- Brand --}}
        <div>
            <div class="gr-footer-brand-text">GET READY.</div>
            <p class="gr-footer-tagline">Heavy fabrics. Honest stitching. Pieces that earn their fade. EST. 2004.</p>
        </div>

        {{-- Shop --}}
        <div class="gr-footer-col">
            <h4>Shop</h4>
            <ul>
                <li><a href="{{ url('tshirts') }}">Tees</a></li>
                <li><a href="{{ url('shirts') }}">Shirts</a></li>
                <li><a href="{{ url('jeans') }}">Jeans</a></li>
                <li><a href="{{ url('jackets') }}">Jackets</a></li>
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