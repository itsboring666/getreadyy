{{-- GET READY — Editorial Navbar --}}
<header class="gr-header">
    <div class="gr-header-inner">
        {{-- Logo --}}
        <a href="{{ url('/') }}" class="gr-logo" aria-label="GET READY Home">
            <div class="gr-logo-badge">GET READY</div>
            <span class="gr-logo-est">EST. '04</span>
        </a>

        {{-- Desktop Navigation --}}
        <nav class="gr-nav" aria-label="Main Navigation">
            <a href="{{ route('products.all') }}" class="gr-nav-link {{ request()->routeIs('products.all') ? 'active' : '' }}">Shop</a>
            <a href="{{ url('tshirts') }}" class="gr-nav-link {{ request()->is('tshirts') ? 'active' : '' }}">Tees</a>
            <a href="{{ url('shirts') }}" class="gr-nav-link {{ request()->is('shirts') ? 'active' : '' }}">Shirts</a>
            <a href="{{ url('jeans') }}" class="gr-nav-link {{ request()->is('jeans') ? 'active' : '' }}">Jeans</a>
            <a href="{{ url('jackets') }}" class="gr-nav-link {{ request()->is('jackets') ? 'active' : '' }}">Jackets</a>
            <a href="{{ route('outfit-builder') }}" class="gr-nav-link {{ request()->routeIs('outfit-builder') ? 'active' : '' }}">Outfit Builder</a>
        </nav>

        {{-- Right Icons & Search --}}
        <div class="gr-nav-icons" style="display: flex; align-items: center; gap: 16px;">
            
            {{-- Global Search Bar --}}
            <form action="{{ route('products.all') }}" method="GET" id="nav-search-form" class="gr-nav-search" style="position: relative; display: flex; align-items: center; background: #161616; border: 1px solid var(--border); border-radius: 0; padding: 4px 12px; margin-right: 8px;">
                <input type="text" id="nav-search-input" name="search" placeholder="Search products..." value="{{ request('search') }}" autocomplete="off" style="background: transparent; border: none; outline: none; font-family: var(--font); font-size: 12px; width: 150px; color: var(--text);">
                <button type="submit" aria-label="Search" style="background: transparent; border: none; cursor: pointer; color: var(--text-secondary); padding: 4px;">
                    <i class="fas fa-search" aria-hidden="true" style="font-size: 12px;"></i>
                </button>

                {{-- Autocomplete Dropdown --}}
                <div id="autocomplete-results" style="display: none; position: absolute; top: calc(100% + 8px); right: -2px; background: #161616; border: 1px solid var(--border); box-shadow: 4px 4px 12px rgba(0,0,0,0.6); z-index: 1000; max-height: 400px; overflow-y: auto; width: 300px;">
                    {{-- JS populated results --}}
                </div>
            </form>
            @guest
                <a href="{{ route('login') }}" class="gr-nav-icon" aria-label="Sign In" title="Sign In">
                    <i class="far fa-user" aria-hidden="true"></i>
                </a>
            @endguest

            @auth
                <a href="{{ route('profile.show') }}" class="gr-nav-icon" aria-label="My Account" title="My Account">
                    <i class="far fa-user" aria-hidden="true"></i>
                </a>
                @if(auth()->user()->user_type === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="gr-nav-icon" aria-label="Admin Dashboard" title="Admin Panel">
                        <i class="fas fa-shield-alt" aria-hidden="true"></i>
                    </a>
                @endif
            @endauth

            @auth
                <a href="{{ route('wishlist.index') }}" class="gr-nav-icon" aria-label="Wishlist" title="Wishlist" style="position: relative;">
                    <i class="far fa-heart" aria-hidden="true"></i>
                    @if(auth()->user()->wishlistItems->count() > 0)
                        <span class="gr-cart-badge" style="background: var(--accent); right: -6px; top: -6px;">{{ auth()->user()->wishlistItems->count() }}</span>
                    @endif
                </a>
            @endauth

            <a href="{{ route('cart') }}" class="gr-nav-icon" aria-label="Shopping Cart" title="Cart">
                <i class="fas fa-shopping-bag" aria-hidden="true"></i>
                @if(session()->has('cart') || auth()->check() && auth()->user()->cartItems()->count() > 0)
                    <span class="gr-cart-badge">{{ auth()->check() ? auth()->user()->cartItems()->count() : count(session('cart', [])) }}</span>
                @else
                    <span class="gr-cart-badge" style="display:none;">0</span>
                @endif
            </a>

            {{-- Mobile Toggle --}}
            <button class="gr-mobile-toggle" id="grMobileToggle" aria-expanded="false" aria-label="Toggle navigation menu">
                <i class="fas fa-bars" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</header>

{{-- Mobile Drawer --}}
<div id="grDrawer" style="display:none; position:fixed; inset:0; z-index:1000;">
    <div id="grOverlay" style="position:absolute; inset:0; background:rgba(0,0,0,0.7);"></div>
    <div style="position:absolute; top:0; right:0; bottom:0; width:300px; background:#161616; display:flex; flex-direction:column; border-left: 1px solid var(--border);">
        <div style="display:flex; justify-content:space-between; align-items:center; padding:16px 20px; border-bottom:1px solid var(--border-light);">
            <div class="gr-logo-badge" style="font-size:14px; padding:5px 10px;">GET READY</div>
            <button id="grDrawerClose" style="background:none; border:none; font-size:18px; cursor:pointer; color:var(--text); padding:5px;" aria-label="Close menu">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
        </div>
        
        <div style="padding:20px; flex:1; overflow-y:auto;">
            <nav style="display:flex; flex-direction:column; gap:0;">
                <a href="{{ route('products.all') }}" style="font-family:var(--font); font-size:11px; font-weight:700; color:var(--text); text-transform:uppercase; letter-spacing:0.06em; padding:14px 0; border-bottom:1px solid var(--border-light); text-decoration:none;">Shop</a>
                <a href="{{ url('tshirts') }}" style="font-family:var(--font); font-size:11px; font-weight:700; color:var(--text); text-transform:uppercase; letter-spacing:0.06em; padding:14px 0; border-bottom:1px solid var(--border-light); text-decoration:none;">Tees</a>
                <a href="{{ url('shirts') }}" style="font-family:var(--font); font-size:11px; font-weight:700; color:var(--text); text-transform:uppercase; letter-spacing:0.06em; padding:14px 0; border-bottom:1px solid var(--border-light); text-decoration:none;">Shirts</a>
                <a href="{{ url('jeans') }}" style="font-family:var(--font); font-size:11px; font-weight:700; color:var(--text); text-transform:uppercase; letter-spacing:0.06em; padding:14px 0; border-bottom:1px solid var(--border-light); text-decoration:none;">Jeans</a>
                <a href="{{ url('jackets') }}" style="font-family:var(--font); font-size:11px; font-weight:700; color:var(--text); text-transform:uppercase; letter-spacing:0.06em; padding:14px 0; border-bottom:1px solid var(--border-light); text-decoration:none;">Jackets</a>
                <a href="{{ route('outfit-builder') }}" style="font-family:var(--font); font-size:11px; font-weight:700; color:var(--accent); text-transform:uppercase; letter-spacing:0.06em; padding:14px 0; border-bottom:1px solid var(--border-light); text-decoration:none;">Outfit Builder</a>
            </nav>
        </div>
        
        <div style="padding:20px; border-top:1px solid var(--border-light);">
            @guest
                <a href="{{ route('login') }}" class="o-btn o-btn-outline" style="width:100%; justify-content:center; margin-bottom:10px;">Sign In</a>
                <a href="{{ route('register') }}" class="o-btn o-btn-primary" style="width:100%; justify-content:center;">Create Account</a>
            @endguest
            @auth
                <a href="{{ route('profile.show') }}" class="o-btn o-btn-ghost" style="width:100%; justify-content:flex-start; margin-bottom:10px;">
                    <i class="far fa-user" aria-hidden="true"></i> My Account
                </a>
                <a href="{{ route('wishlist.index') }}" class="o-btn o-btn-ghost" style="width:100%; justify-content:flex-start; margin-bottom:10px;">
                    <i class="far fa-heart" aria-hidden="true"></i> My Wishlist
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="o-btn o-btn-ghost" style="width:100%; justify-content:flex-start; color:var(--danger);">
                        <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Sign Out
                    </button>
                </form>
            @endauth
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('grMobileToggle');
    const drawer = document.getElementById('grDrawer');
    const overlay = document.getElementById('grOverlay');
    const closeBtn = document.getElementById('grDrawerClose');

    function openMenu() {
        drawer.style.display = 'block';
        toggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
        drawer.style.display = 'none';
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
    }

    if(toggle) toggle.addEventListener('click', openMenu);
    if(closeBtn) closeBtn.addEventListener('click', closeMenu);
    if(overlay) overlay.addEventListener('click', closeMenu);

    // Autocomplete Search logic
    const searchInput = document.getElementById('nav-search-input');
    const resultsContainer = document.getElementById('autocomplete-results');
    let debounceTimer;

    if (searchInput && resultsContainer) {
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const query = this.value.trim();

            if (query.length < 2) {
                resultsContainer.innerHTML = '';
                resultsContainer.style.display = 'none';
                return;
            }

            // Show loading state
            resultsContainer.innerHTML = '<div style="padding: 16px; font-family: monospace; font-size: 11px; text-transform: uppercase; color: var(--text-secondary); text-align: center;"><i class="fas fa-spinner fa-spin" style="margin-right: 8px;"></i> TRANSMITTING...</div>';
            resultsContainer.style.display = 'block';

            debounceTimer = setTimeout(() => {
                fetch(`{{ route('products.autocomplete') }}?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length === 0) {
                            resultsContainer.innerHTML = '<div style="padding: 16px; font-family: monospace; font-size: 11px; text-transform: uppercase; color: #dc3545; text-align: center;">NO LOGS MATCHED</div>';
                            return;
                        }

                        let html = '';
                        data.forEach(item => {
                            html += `
                                <a href="${item.url}" style="display: flex; gap: 12px; padding: 12px; border-bottom: 1px solid var(--border-light); text-decoration: none; color: var(--text); align-items: center; transition: background 0.2s;" onmouseover="this.style.background='#1a1a1a'" onmouseout="this.style.background='transparent'">
                                    <div style="width: 40px; height: 50px; background: var(--bg); flex-shrink: 0; border: 1px solid var(--border-light);">
                                        <img src="${item.image}" alt="${item.name}" onerror="this.style.display='none'" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div style="flex: 1; min-width: 0; text-align: left;">
                                        <span style="font-family: monospace; font-size: 9px; color: var(--text-secondary); text-transform: uppercase; background: var(--bg); padding: 2px 6px; display: inline-block; margin-bottom: 4px;">
                                            ${item.category}
                                        </span>
                                        <span style="font-family: var(--font-heading); font-size: 13px; font-weight: bold; margin: 0; color: var(--text); display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                            ${item.name}
                                        </span>
                                    </div>
                                    <div style="font-family: var(--font); font-size: 12px; font-weight: bold; color: var(--text); flex-shrink: 0;">
                                        ${item.price}
                                    </div>
                                </a>
                            `;
                        });
                        resultsContainer.innerHTML = html;
                    })
                    .catch(err => {
                        resultsContainer.innerHTML = '<div style="padding: 16px; font-family: monospace; font-size: 11px; text-transform: uppercase; color: #dc3545; text-align: center;">TRANSMISSION ERROR</div>';
                    });
            }, 250);
        });

        // Hide when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                resultsContainer.style.display = 'none';
            }
        });

        // Show when focusing back if query has length >= 2
        searchInput.addEventListener('focus', function() {
            if (this.value.trim().length >= 2) {
                resultsContainer.style.display = 'block';
            }
        });
    }
});
</script>
