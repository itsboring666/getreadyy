@extends('layouts.front')
@section('title', 'Outfit Builder | GET READY')

@section('content')


<style>
/* Reel Spinning Animations */
.reel-viewport {
    position: relative;
    width: 100%;
    height: 100%;
    overflow: hidden;
}
.reel-viewport.spinning .main-product-img {
    filter: blur(4px) grayscale(50%) !important;
    opacity: 0.8 !important;
    animation: slotSpin 0.15s linear infinite !important;
}
@keyframes slotSpin {
    0% { transform: scale(0.95) translateY(-20px) !important; opacity: 0.6 !important; }
    50% { transform: scale(0.95) translateY(20px) !important; opacity: 0.9 !important; }
    100% { transform: scale(0.95) translateY(-20px) !important; opacity: 0.6 !important; }
}
.reel-viewport::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 200%;
    background: repeating-linear-gradient(
        0deg,
        rgba(0, 0, 0, 0) 0px,
        rgba(0, 0, 0, 0) 40px,
        rgba(0, 0, 0, 0.04) 40px,
        rgba(0, 0, 0, 0.04) 80px
    );
    z-index: 2;
    pointer-events: none;
    display: none;
}
.reel-viewport.spinning::after {
    display: block;
    animation: motionLines 0.1s linear infinite;
}
@keyframes motionLines {
    0% { transform: translateY(0); }
    100% { transform: translateY(-80px); }
}
@keyframes cardPop {
    0% { transform: scale(0.9) rotate(-1deg); filter: blur(2px); }
    70% { transform: scale(1.04) rotate(0.5deg); filter: blur(0); }
    100% { transform: scale(1) rotate(0); }
}
.card-settling {
    animation: cardPop 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
}
</style>

{{-- ─── HERO ───────────────────────────────────────── --}}
<section class="gr-hero" style="min-height: 250px; padding: 40px 24px 20px;">
    <div class="gr-hero-text" style="padding-top: 0; max-width: 800px;">
        <div class="gr-hero-label">EXPERIMENTAL</div>
        <h1 class="gr-hero-heading" style="font-size: clamp(36px, 5vw, 64px); margin-bottom: 12px;">
            THE <span class="highlight">OUTFIT</span> WHEEL
        </h1>
        <p class="gr-hero-subtitle" style="margin-bottom: 24px;">
            Can't decide? Let chance dress you. Lock the slots you like, choose a category filter, and spin the rest.
        </p>

        {{-- Category/Theme Filter Dropdown --}}
        <div style="margin-bottom: 24px; display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
            <label for="category-filter" style="font-family: var(--font); font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-secondary);">
                FILTER BY CATEGORY:
            </label>
            <select id="category-filter" style="padding: 10px 16px; font-family: var(--font); font-size: 13px; border: 2px solid var(--text); background: #fff; font-weight: bold; cursor: pointer; outline: none; border-radius: 0;">
                <option value="">ALL CATEGORIES</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $selectedCategoryId == $cat->id ? 'selected' : '' }}>
                        {{ strtoupper($cat->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <a href="{{ route('outfit-builder') }}" class="gr-hero-btn-primary" id="spin-btn" style="background: var(--text); text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
            <i class="fas fa-sync-alt" aria-hidden="true"></i> SPIN AGAIN
        </a>
    </div>
</section>

{{-- ─── OUTFIT DISPLAY ───────────────────────────────────────── --}}
<div class="gr-wardrobe" style="padding: 40px 24px 80px;">
    @if($outfit->filter()->count() > 0)
    <form action="{{ route('cart.add-multiple') }}" method="POST" id="outfit-form">
        @csrf
        <div class="gr-product-grid gr-product-grid-3">
            @php
            $phs = [
                asset('assets/images/logo.png'),
                asset('assets/images/logo.png'),
                asset('assets/images/logo.png'),
            ];
            @endphp

            @foreach($outfit as $i => $product)
            @if(!$product) @continue @endif
            @php
                $availableSizes = $product->sizes->where('stock', '>', 0);
                $hasStock = $availableSizes->count() > 0;
                $defaultPrice = $hasStock ? $availableSizes->min('price') : ($product->price ?? 0);
                $defaultOrigPrice = $hasStock ? ($availableSizes->sortBy('price')->first()->original_price ?? null) : null;
                $slotName = $i === 0 ? 'outerwear' : ($i === 1 ? 'top' : 'bottom');
                $isLocked = request('lock_' . $slotName) == $product->id;
            @endphp
            <div class="gr-product-card" id="outfit-card-{{ $i }}" style="background: #161616; padding: 12px; display: flex; flex-direction: column; justify-content: space-between; position: relative;">
                <div>
                    {{-- Checkbox / Toggle --}}
                    <div style="position: absolute; top: 20px; right: 20px; z-index: 10;">
                        <input type="checkbox" name="items[{{ $i }}][selected]" value="1" 
                               {{ $hasStock ? 'checked' : 'disabled' }}
                               class="outfit-item-checkbox" 
                               data-index="{{ $i }}"
                               style="width: 20px; height: 20px; accent-color: var(--text); cursor: pointer;"
                               aria-label="Select {{ $product->name }}">
                    </div>

                    {{-- Lock Slot Toggle --}}
                    <div style="position: absolute; top: 20px; left: 20px; z-index: 10;">
                        <button type="button" class="lock-toggle-btn px-2.5 py-1 text-xs border-2 border-black font-mono font-bold transition duration-200"
                                data-slot="{{ $slotName }}" 
                                data-product-id="{{ $product->id }}"
                                data-locked="{{ $isLocked ? 'true' : 'false' }}"
                                style="background: {{ $isLocked ? '#7f1d1d' : '#1e1e1e' }}; color: #e8e8e8; border: 1px solid #3a3a3a; box-shadow: 2px 2px 0px #000; cursor: pointer;">
                            {{ $isLocked ? '🔒 LOCKED' : '🔓 UNLOCKED' }}
                        </button>
                    </div>

                    @php
                        $validImages = array_filter([$product->image, $product->image_2, $product->image_3, $product->image_4]);
                        $imageUrls = array_map(function ($img) {
                            return get_storage_url($img);
                        }, array_values($validImages));
                    @endphp
                    <div class="gr-product-card-img" style="aspect-ratio: 3/4; position: relative; overflow: hidden; border: 2px solid var(--primary); background: #111;">
                        <a href="{{ route('product.view', $product->id) }}" class="product-link" style="display: block; width: 100%; height: 100%;">
                            <div class="reel-viewport">
                                <img src="{{ get_storage_url($product->image) ?: 'https://placehold.co/400x600/111111/e8e8e8?text=NO+IMAGE' }}" 
                                     class="main-product-img hover-slideshow"
                                     data-images='@json($imageUrls)'
                                     onerror="this.onerror=null; this.src='https://placehold.co/400x600/111111/e8e8e8?text=NO+IMAGE';" 
                                     alt="{{ $product->name }}" loading="lazy" style="width:100%; height:100%; object-fit:cover; display: block;">
                            </div>
                        </a>
                    </div>
                    
                    <div class="gr-product-card-body" style="padding: 16px 8px 8px;">
                        <div class="gr-product-name" style="font-size: 16px; font-weight: 600;">
                            <a href="{{ route('product.view', $product->id) }}" style="color: var(--text); text-decoration: none;">
                                {{ $product->name }}
                            </a>
                        </div>
                        <div class="gr-product-meta" style="margin-top: 8px;">
                            <span class="gr-product-cat">{{ $product->category->name ?? 'GET READY' }}</span>
                            <div style="display: flex; align-items: baseline; gap: 6px;">
                                @if($defaultOrigPrice)
                                    <del style="color: var(--text-muted); font-size: 0.75em;">₹{{ number_format($defaultOrigPrice, 2) }}</del>
                                @endif
                                <span class="gr-product-price" id="price-display-{{ $i }}" style="font-weight: bold;" data-base-price="{{ $defaultPrice }}">
                                    ₹{{ number_format($defaultPrice, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Interactive controls inside the card --}}
                <div style="padding: 8px; border-top: 1px solid var(--border-light); margin-top: 12px;">
                    <input type="hidden" name="items[{{ $i }}][product_id]" value="{{ $product->id }}">
                    <input type="hidden" name="items[{{ $i }}][quantity]" value="1">
                    
                    @if($hasStock)
                        <label for="size-select-{{ $i }}" style="font-family: var(--font); font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 4px; color: var(--text-secondary);">Size</label>
                        <select name="items[{{ $i }}][size]" id="size-select-{{ $i }}" class="outfit-size-select" data-index="{{ $i }}" style="width: 100%; padding: 8px; font-family: var(--font); font-size: 12px; border: 1px solid var(--border); background: #1a1a1a; color: #e8e8e8; cursor: pointer; text-transform: uppercase;">
                            @foreach($availableSizes as $sz)
                                <option value="{{ $sz->size }}" data-price="{{ $sz->price }}">
                                    {{ $sz->size }} (₹{{ number_format($sz->price, 2) }})
                                </option>
                            @endforeach
                        </select>
                    @else
                        <div style="color: var(--danger); font-family: var(--font); font-size: 12px; padding: 8px 0; text-align: center; font-weight: bold;">
                            OUT OF STOCK
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        {{-- OUTFIT SUMMARY --}}
        <div style="margin-top: 60px; padding: 40px; background: #161616; border: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 24px;">
            <div>
                <div style="font-family: var(--font-heading); font-size: 32px; margin-bottom: 8px;">THE FULL KIT</div>
                <div id="selected-items-count" style="color: var(--text-secondary); font-family: var(--font); font-size: 12px; letter-spacing: 0.05em;">3 Items Selected</div>
            </div>
            
            <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 12px;">
                <div id="total-price-display" style="font-family: var(--font); font-size: 18px; font-weight: bold;">Total Value: ₹{{ number_format($totalPrice, 2) }}</div>
                
                @auth
                    <button type="submit" id="add-to-cart-btn" class="gr-hero-btn-primary" style="background: var(--text); border: none; font-size: 11px; padding: 14px 32px; cursor: pointer;">
                        <i class="fas fa-shopping-bag" aria-hidden="true" style="margin-right: 8px;"></i> ADD SELECTED OUTFIT TO CART
                    </button>
                @else
                    <div style="text-align: right;">
                        <a href="{{ route('login') }}" class="gr-hero-btn-primary" style="background: var(--text); text-decoration: none;">
                            <i class="fas fa-sign-in-alt" aria-hidden="true" style="margin-right: 8px;"></i> SIGN IN TO PURCHASE OUTFIT
                        </a>
                        <p style="font-size: 11px; color: var(--text-muted); margin-top: 6px;">You must be logged in to add items to your cart.</p>
                    </div>
                @endauth
            </div>
        </div>
    </form>
    @else
    <div style="text-align: center; padding: 60px;">
        <p style="font-family: var(--font-serif); font-size: 18px; color: var(--text-muted); font-style: italic;">We don't have enough stock right now to build a full outfit. Check back later!</p>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.outfit-item-checkbox');
    const totalPriceDisplay = document.getElementById('total-price-display');
    const selectedCountDisplay = document.getElementById('selected-items-count');
    const addToCartBtn = document.getElementById('add-to-cart-btn');
    const catFilter = document.getElementById('category-filter');
    const spinBtn = document.getElementById('spin-btn');

    function calculateTotal() {
        let total = 0;
        let selectedCount = 0;

        checkboxes.forEach(cb => {
            if (cb.checked && !cb.disabled) {
                selectedCount++;
                const idx = cb.dataset.index;
                const sizeSelect = document.getElementById(`size-select-${idx}`);
                if (sizeSelect) {
                    const activeOption = sizeSelect.options[sizeSelect.selectedIndex];
                    const price = parseFloat(activeOption.dataset.price);
                    total += price;

                    // Update individual card price display
                    document.getElementById(`price-display-${idx}`).textContent = '₹' + price.toLocaleString('en-IN', {minimumFractionDigits: 2});
                } else {
                    const priceDisp = document.getElementById(`price-display-${idx}`);
                    const price = parseFloat(priceDisp.dataset.basePrice) || 0;
                    total += price;
                }
            }
        });

        totalPriceDisplay.textContent = 'Total Value: ₹' + total.toLocaleString('en-IN', {minimumFractionDigits: 2});
        selectedCountDisplay.textContent = selectedCount + ' ' + (selectedCount === 1 ? 'Item' : 'Items') + ' Selected';

        if (addToCartBtn) {
            addToCartBtn.disabled = (selectedCount === 0);
            addToCartBtn.style.opacity = (selectedCount === 0) ? '0.5' : '1';
            addToCartBtn.style.cursor = (selectedCount === 0) ? 'not-allowed' : 'pointer';
        }
    }

    function updateSpinUrl() {
        const baseUrl = "{{ route('outfit-builder') }}";
        const params = new URLSearchParams();

        if (catFilter && catFilter.value) {
            params.append('category_id', catFilter.value);
        }

        document.querySelectorAll('.lock-toggle-btn').forEach(btn => {
            if (btn.dataset.locked === 'true') {
                params.append('lock_' + btn.dataset.slot, btn.dataset.productId);
            }
        });

        const queryString = params.toString();
        spinBtn.href = baseUrl + (queryString ? '?' + queryString : '');
    }

    // Bind lock toggle click events
    document.querySelectorAll('.lock-toggle-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const isLocked = this.dataset.locked === 'true';
            if (isLocked) {
                this.dataset.locked = 'false';
                this.textContent = '🔓 UNLOCKED';
                this.style.background = '#1e1e1e';
            } else {
                this.dataset.locked = 'true';
                this.textContent = '🔒 LOCKED';
                this.style.background = '#bebc65';
            }
            updateSpinUrl();
        });
    });

    // Bind category filter change
    if (catFilter) {
        catFilter.addEventListener('change', function() {
            updateSpinUrl();
            window.location.href = spinBtn.href;
        });
    }

    // Bind checkbox change handlers
    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            const idx = this.dataset.index;
            const card = document.getElementById(`outfit-card-${idx}`);
            const selectEl = document.getElementById(`size-select-${idx}`);
            
            if (this.checked) {
                card.style.opacity = '1';
                if (selectEl) selectEl.disabled = false;
            } else {
                card.style.opacity = '0.5';
                if (selectEl) selectEl.disabled = true;
            }
            calculateTotal();
        });
    });

    // Bind size select change handlers
    document.querySelectorAll('.outfit-size-select').forEach(select => {
        select.addEventListener('change', calculateTotal);
    });

    // Handle spin btn AJAX request
    if (spinBtn) {
        spinBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get filter & locks
            const catId = catFilter ? catFilter.value : '';
            const locks = {};
            document.querySelectorAll('.lock-toggle-btn').forEach(btn => {
                const slot = btn.dataset.slot;
                const locked = btn.dataset.locked === 'true';
                if (locked) {
                    locks['lock_' + slot] = btn.dataset.productId;
                }
            });

            // Start spin animation on unlocked slots
            const spinningSlots = [];
            document.querySelectorAll('.lock-toggle-btn').forEach((btn, index) => {
                if (btn.dataset.locked !== 'true') {
                    const viewport = document.querySelector(`#outfit-card-${index} .reel-viewport`);
                    if (viewport) {
                        viewport.classList.add('spinning');
                        spinningSlots.push(index);
                    }
                }
            });

            // If nothing is spinning (all locked), just exit
            if (spinningSlots.length === 0) {
                return;
            }

            // Disable button
            spinBtn.disabled = true;
            spinBtn.style.opacity = '0.5';
            spinBtn.innerHTML = '<i class="fas fa-sync-alt fa-spin"></i> SPINNING...';

            // Build request URL
            const url = new URL("{{ route('outfit-builder') }}");
            if (catId) url.searchParams.append('category_id', catId);
            Object.keys(locks).forEach(key => {
                url.searchParams.append(key, locks[key]);
            });

            const startTime = Date.now();

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                // Play for at least 1.2s
                const elapsed = Date.now() - startTime;
                const delay = Math.max(0, 1200 - elapsed);

                setTimeout(() => {
                    data.outfit.forEach((item, index) => {
                        if (!item) return; // Prevent crashes if backend fallback failed
                        const slotName = index === 0 ? 'outerwear' : (index === 1 ? 'top' : 'bottom');
                        const lockBtn = document.querySelector(`.lock-toggle-btn[data-slot="${slotName}"]`);
                        if (lockBtn && lockBtn.dataset.locked !== 'true') {
                            const card = document.getElementById(`outfit-card-${index}`);
                            const viewport = card.querySelector('.reel-viewport');
                            const img = card.querySelector('.main-product-img');
                            const nameLink = card.querySelector('.gr-product-name a');
                            const catSpan = card.querySelector('.gr-product-cat');
                            const priceSpan = card.querySelector(`#price-display-${index}`);
                            const linkElement = card.querySelector('.product-link');

                            // Set product values
                            if (img) {
                                img.src = item.image || 'https://placehold.co/400x600/111111/e8e8e8?text=NO+IMAGE';
                                img.onerror = function() {
                                    this.onerror = null;
                                    this.src = 'https://placehold.co/400x600/111111/e8e8e8?text=NO+IMAGE';
                                };
                                img.setAttribute('data-images', JSON.stringify(item.images || [item.image || 'https://placehold.co/400x600/111111/e8e8e8?text=NO+IMAGE']));
                                delete img.dataset.slideshowInitialized;
                            }
                            if (nameLink) {
                                nameLink.textContent = item.name;
                                nameLink.href = item.view_url;
                            }
                            if (linkElement) linkElement.href = item.view_url;
                            if (catSpan) catSpan.textContent = item.category_name;
                            
                            if (priceSpan) {
                                priceSpan.dataset.basePrice = item.price;
                                priceSpan.textContent = '₹' + item.price.toLocaleString('en-IN', {minimumFractionDigits: 2});
                            }

                            // Update inputs and sizes select dropdown
                            const sizeContainer = card.querySelector('.outfit-size-select')?.parentElement;
                            const prodIdInput = card.querySelector(`input[name="items[${index}][product_id]"]`);

                            if (prodIdInput) prodIdInput.value = item.id;
                            if (lockBtn) lockBtn.dataset.productId = item.id;

                            if (sizeContainer) {
                                if (item.has_stock) {
                                    let selectHtml = `<label for="size-select-${index}" style="font-family: var(--font); font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 4px; color: var(--text-secondary);">Size</label>`;
                                    selectHtml += `<select name="items[${index}][size]" id="size-select-${index}" class="outfit-size-select" data-index="${index}" style="width: 100%; padding: 8px; font-family: var(--font); font-size: 12px; border: 1px solid var(--border); background: #1a1a1a; color: #e8e8e8; cursor: pointer; text-transform: uppercase;">`;
                                    item.sizes.forEach(sz => {
                                        selectHtml += `<option value="${sz.size}" data-price="${sz.price}">${sz.size} (₹${sz.price.toLocaleString('en-IN', {minimumFractionDigits: 2})})</option>`;
                                    });
                                    selectHtml += `</select>`;
                                    sizeContainer.innerHTML = selectHtml;
                                } else {
                                    sizeContainer.innerHTML = `<div style="color: var(--danger); font-family: var(--font); font-size: 12px; padding: 8px 0; text-align: center; font-weight: bold;">OUT OF STOCK</div>`;
                                }
                            }

                            // Stop spin, trigger pop transition
                            viewport.classList.remove('spinning');
                            viewport.classList.add('card-settling');
                            setTimeout(() => {
                                viewport.classList.remove('card-settling');
                            }, 500);
                        }
                    });

                    // Re-bind click event to new size selectors
                    document.querySelectorAll('.outfit-size-select').forEach(select => {
                        select.removeEventListener('change', calculateTotal);
                        select.addEventListener('change', calculateTotal);
                    });

                    calculateTotal();
                    updateSpinUrl();

                    // Restore button state
                    spinBtn.disabled = false;
                    spinBtn.style.opacity = '1';
                    spinBtn.innerHTML = '<i class="fas fa-sync-alt"></i> SPIN AGAIN';
                }, delay);
            })
            .catch(err => {
                console.error("Spin AJAX error", err);
                window.location.href = spinBtn.href;
            });
        });
    }

    // Initial run
    calculateTotal();
    updateSpinUrl();
});
</script>
@endsection
