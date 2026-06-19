@extends('layouts.front')
@section('title', $product->name . ' | GET READY')

@section('content')

<div class="o-breadcrumb">
    <div class="o-breadcrumb-inner">
        <a href="{{ url('/') }}">Home</a> <span class="sep">/</span>
        <a href="{{ route('products.all') }}">Shop</a> <span class="sep">/</span>
        @if($product->category)<a href="{{ url($product->category->slug) }}">{{ $product->category->name }}</a> <span class="sep">/</span>@endif
        <span class="current">{{ $product->name }}</span>
    </div>
</div>

<div class="o-pdp">
    {{-- Gallery --}}
    @php
    $imgs = array_values(array_filter([
        $product->image,
        $product->image_2 ?? null,
        $product->image_3 ?? null,
        $product->image_4 ?? null,
    ]));
    $fb = 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10?auto=format&fit=crop&w=800&q=80';
    @endphp

    <div class="o-pdp-gallery">
        <div class="o-pdp-main">
            <img id="mainImg" 
                 src="{{ asset('storage/' . ($imgs[0] ?? '')) }}" 
                 onerror="this.src='{{ $fb }}'" 
                 alt="{{ $product->name }}">
        </div>
        @if(count($imgs) > 1)
        <div class="o-pdp-thumbs" role="group" aria-label="Product thumbnails">
            @foreach($imgs as $idx => $im)
            <button class="o-pdp-thumb {{ $idx === 0 ? 'active' : '' }}" 
                 onclick="swImg('{{ asset('storage/' . $im) }}', this, '{{ $fb }}')"
                 aria-label="View image {{ $idx + 1 }}">
                <img src="{{ asset('storage/' . $im) }}" 
                     onerror="this.src='{{ $fb }}'" 
                     alt="">
            </button>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Info --}}
    <div class="o-pdp-info">
        <span class="o-pdp-cat">{{ $product->category->name ?? 'Outfit 818' }}</span>
        <h1 class="o-pdp-title">{{ $product->name }}</h1>
        
        @php
            $topReviewCount = $product->reviews->count();
            $topAvgRating = $topReviewCount > 0 ? round($product->reviews->avg('rating'), 1) : 0;
        @endphp
        <div class="o-pdp-rating-top" style="margin-top: -6px; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
            @if($topReviewCount > 0)
                <div style="color: var(--accent); font-size: 14px; letter-spacing: 2px;">
                    @for($i = 1; $i <= 5; $i++)
                        <span>{{ $i <= round($topAvgRating) ? '✦' : '✧' }}</span>
                    @endfor
                </div>
                <span style="font-size: 11px; color: var(--text-secondary); text-decoration: underline; cursor: pointer;" onclick="document.getElementById('reviews-section').scrollIntoView({behavior: 'smooth'})">
                    {{ $topAvgRating }} ({{ $topReviewCount }} {{ Str::plural('Review', $topReviewCount) }})
                </span>
            @else
                <span style="font-size: 11px; color: var(--text-muted); cursor: pointer;" onclick="document.getElementById('reviews-section').scrollIntoView({behavior: 'smooth'})">
                    No reviews yet — write one
                </span>
            @endif
        </div>

        <div class="o-pdp-price unset" id="pdpPrice" aria-live="polite">Select a size to see price</div>

        <div class="o-trust-badges">
            <div class="o-trust-badge"><i class="fas fa-check" aria-hidden="true"></i> Premium Quality Material</div>
            <div class="o-trust-badge"><i class="fas fa-check" aria-hidden="true"></i> Free Shipping on orders over ₹999</div>
            <div class="o-trust-badge"><i class="fas fa-check" aria-hidden="true"></i> 30-Day Easy Returns</div>
        </div>

        @auth
        <form action="{{ route('cart.add') }}" method="POST" id="pdpForm">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="size" id="hiddenSz" value="" required>

            {{-- Size --}}
            <div style="margin-bottom:20px;">
                <div class="o-size-header">
                    <span id="sizeGroupLabel">Select Size <span style="color:var(--danger);font-weight:400;">*</span></span>
                    <a href="#" aria-label="View size guide">Size Guide</a>
                </div>
                <div class="o-sizes" role="group" aria-labelledby="sizeGroupLabel">
                    @foreach($product->sizes as $sz)
                    <button type="button" 
                            class="o-size {{ $sz->stock == 0 ? 'oos' : '' }}" 
                            data-size="{{ $sz->size }}" 
                            data-price="{{ $sz->price }}" 
                            data-stock="{{ $sz->stock }}"
                            onclick="{{ $sz->stock > 0 ? 'pickSz(this)' : 'void(0)' }}"
                            {{ $sz->stock == 0 ? 'disabled aria-disabled="true"' : '' }}
                            aria-label="Size {{ $sz->size }} {{ $sz->stock == 0 ? '(Out of stock)' : '' }}">
                        {{ $sz->size }}
                    </button>
                    @endforeach
                </div>
                <div class="o-stock" id="stockMsg" style="display:none;" aria-live="polite"></div>
                <div id="lowStockUrgency" style="display: none; font-family: monospace; font-size: 13px; font-weight: bold; background: #1a1400; border: 2px solid #854d0e; color: #fcd34d; padding: 10px; margin: 12px 0; letter-spacing: 0.05em; text-align: center; text-transform: uppercase; box-shadow: 2px 2px 0px #000;">
                    ⚠️ ONLY <span id="lowStockCount">0</span> UNITS LEFT - ACT FAST!
                </div>
            </div>

            {{-- Qty --}}
            <div class="o-qty-row">
                <label for="qtyInp" class="o-qty-label">Quantity</label>
                <div class="o-qty">
                    <button type="button" class="o-qty-btn" onclick="adjQ(-1)" aria-label="Decrease quantity">−</button>
                    <input type="number" name="quantity" id="qtyInp" class="o-qty-input" value="1" min="1" max="10">
                    <button type="button" class="o-qty-btn" onclick="adjQ(1)" aria-label="Increase quantity">+</button>
                </div>
            </div>

            <div style="display:flex; flex-direction:column; gap:12px; margin-top:28px; margin-bottom:32px;">
                <button type="submit" name="action" value="add" class="o-btn o-btn-secondary o-btn-full o-btn-lg">
                    <i class="fas fa-shopping-bag" aria-hidden="true" style="margin-right:4px;"></i> Add to Cart
                </button>
                <button type="submit" name="action" value="buy_now" class="o-btn o-btn-primary o-btn-full o-btn-lg">
                    Buy It Now
                </button>
            </div>
        </form>
        @auth
            @php
                $inWishlist = auth()->user()->wishlistItems->contains('product_id', $product->id);
            @endphp
            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" style="margin-top: -20px; margin-bottom: 32px;">
                @csrf
                <button type="submit" class="o-btn o-btn-outline o-btn-full" style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <i class="{{ $inWishlist ? 'fas' : 'far' }} fa-heart" aria-hidden="true" style="color: {{ $inWishlist ? 'var(--accent)' : 'inherit' }};"></i>
                    {{ $inWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}
                </button>
            </form>
        @endauth
        @else
        <div style="background:var(--bg); border:1px solid var(--border); border-radius:var(--radius); padding:20px; margin-bottom:32px; text-align:center;">
            <p style="margin-bottom:12px; font-weight:500;">Please sign in to purchase this item.</p>
            <a href="{{ route('login') }}" class="o-btn o-btn-primary o-btn-full">Sign In</a>
        </div>
        @endauth

        {{-- Accordion --}}
        <div class="o-accordion">
            <div class="o-acc-item open" id="aDesc">
                <button class="o-acc-trigger" onclick="togAcc('aDesc')" aria-expanded="true" aria-controls="descContent">
                    Product Details <i class="fas fa-plus o-acc-icon" aria-hidden="true"></i>
                </button>
                <div class="o-acc-body" id="descContent">
                    <div class="o-acc-body-inner">
                        {{ $product->description ?: 'Designed for comfort and durability. This essential piece is made with high-quality materials to ensure long-lasting wear and a perfect fit.' }}
                    </div>
                </div>
            </div>
            <div class="o-acc-item" id="aShip">
                <button class="o-acc-trigger" onclick="togAcc('aShip')" aria-expanded="false" aria-controls="shipContent">
                    Shipping & Returns <i class="fas fa-plus o-acc-icon" aria-hidden="true"></i>
                </button>
                <div class="o-acc-body" id="shipContent">
                    <div class="o-acc-body-inner">
                        Free shipping on orders over ₹999. Standard delivery takes 3-5 business days. Not happy with your purchase? Return it within 30 days for a full refund or exchange.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="o-reviews-container" id="reviews-section">
    @php
        $reviewCount = $product->reviews->count();
        $avgRating = $reviewCount > 0 ? round($product->reviews->avg('rating'), 1) : 0;
        
        $starsCount = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        foreach($product->reviews as $rev) {
            $r = (int)$rev->rating;
            if (isset($starsCount[$r])) {
                $starsCount[$r]++;
            }
        }
        
        $hasReviewed = false;
        if(auth()->check()) {
            $hasReviewed = $product->reviews->contains('user_id', auth()->id());
        }
    @endphp

    <div class="o-reviews-header">
        <h2 class="o-reviews-heading">Customer Reviews</h2>
        <span style="font-size: 12px; color: var(--text-secondary);">{{ $reviewCount }} {{ Str::plural('Review', $reviewCount) }}</span>
    </div>

    <div class="o-reviews-grid">
        {{-- Stats --}}
        <div class="o-reviews-stats">
            <div class="o-reviews-score">{{ $avgRating }}</div>
            <div class="o-reviews-score-stars" style="color: var(--accent); font-size: 20px; letter-spacing: 2px; margin-bottom: 8px;">
                @for($i = 1; $i <= 5; $i++)
                    <span>{{ $i <= round($avgRating) ? '✦' : '✧' }}</span>
                @endfor
            </div>
            <div class="o-reviews-count">Based on {{ $reviewCount }} {{ Str::plural('review', $reviewCount) }}</div>
            
            <div class="o-reviews-distribution">
                @foreach([5, 4, 3, 2, 1] as $stars)
                    @php
                        $percentage = $reviewCount > 0 ? ($starsCount[$stars] / $reviewCount) * 100 : 0;
                    @endphp
                    <div class="o-reviews-dist-row">
                        <span class="o-reviews-dist-label">{{ $stars }} <span style="font-size: 11px; color: var(--accent);">✦</span></span>
                        <div class="o-reviews-dist-bar-bg">
                            <div class="o-reviews-dist-bar" style="width: {{ $percentage }}%;"></div>
                        </div>
                        <span class="o-reviews-dist-val">{{ $starsCount[$stars] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Reviews List & Form --}}
        <div class="o-reviews-list-sec">
            {{-- Form Box --}}
            <div class="o-review-form-box">
                @auth
                    @if($hasReviewed)
                        <p style="font-size: 12px; color: var(--text-secondary);"><i class="fas fa-info-circle" style="color: var(--accent); margin-right: 6px;"></i> You have already reviewed this product.</p>
                    @else
                        <h3 class="o-review-form-title">Write a Review</h3>
                        <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                            @csrf
                            <div class="o-review-form-group">
                                <label class="o-review-form-label">Rating <span style="color: var(--danger);">*</span></label>
                                <div class="retro-stars-input" style="display: flex; gap: 8px; font-size: 24px; color: var(--text-muted); cursor: pointer; margin-bottom: 12px; user-select: none;">
                                    <span class="retro-star" data-value="1" style="transition: transform 0.15s, color 0.15s; display: inline-block;">✧</span>
                                    <span class="retro-star" data-value="2" style="transition: transform 0.15s, color 0.15s; display: inline-block;">✧</span>
                                    <span class="retro-star" data-value="3" style="transition: transform 0.15s, color 0.15s; display: inline-block;">✧</span>
                                    <span class="retro-star" data-value="4" style="transition: transform 0.15s, color 0.15s; display: inline-block;">✧</span>
                                    <span class="retro-star" data-value="5" style="transition: transform 0.15s, color 0.15s; display: inline-block;">✧</span>
                                </div>
                                <input type="hidden" name="rating" id="ratingInput" value="" required>
                            </div>
                            
                            <div class="o-review-form-group">
                                <label for="reviewComment" class="o-review-form-label">Review Comment</label>
                                <textarea name="comment" id="reviewComment" rows="4" class="o-review-input" placeholder="Share your experience with this product..."></textarea>
                            </div>
                            
                            <button type="submit" class="o-btn o-btn-primary" style="padding: 12px 24px; font-size: 11px;">Submit Review</button>
                        </form>
                    @endif
                @else
                    <div style="text-align: center; padding: 12px;">
                        <p style="font-size: 12px; color: var(--text-secondary); margin-bottom: 12px;">Please sign in to write a product review.</p>
                        <a href="{{ route('login') }}" class="o-btn o-btn-primary" style="display: inline-block; padding: 10px 20px; font-size: 10px;">Sign In</a>
                    </div>
                @endauth
            </div>

            {{-- Reviews List --}}
            @if($reviewCount > 0)
                <div style="display: flex; flex-direction: column; gap: 24px;">
                    @foreach($product->reviews->sortByDesc('created_at') as $review)
                        <div class="o-review-item">
                            <div class="o-review-meta">
                                <span class="o-review-user">{{ $review->user->name }}</span>
                                <span class="o-review-date">{{ $review->created_at->format('F d, Y') }}</span>
                            </div>
                            <div class="o-review-rating" style="color: var(--accent); font-size: 14px; letter-spacing: 2px; margin-bottom: 8px;">
                                 @for($i = 1; $i <= 5; $i++)
                                     <span>{{ $i <= $review->rating ? '✦' : '✧' }}</span>
                                 @endfor
                             </div>
                            <div class="o-review-comment">
                                {!! nl2br(e($review->comment)) !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="text-align: center; padding: 48px; border: 1px dashed var(--border); background: #161616;">
                    <i class="far fa-comments" style="font-size: 32px; color: var(--text-muted); margin-bottom: 12px;"></i>
                    <p style="font-size: 12px; color: var(--text-secondary);">No reviews yet. Be the first to share your thoughts!</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function swImg(src, el, fb){
    var m = document.getElementById('mainImg');
    m.style.opacity = '0.5';
    m.src = src;
    m.onerror = function(){ this.src = fb; };
    setTimeout(function(){ m.style.opacity = '1'; }, 200);
    
    document.querySelectorAll('.o-pdp-thumb').forEach(function(t){ t.classList.remove('active'); });
    el.classList.add('active');
}

function pickSz(btn){
    document.querySelectorAll('.o-size').forEach(function(b){ b.classList.remove('active'); });
    btn.classList.add('active');
    document.getElementById('hiddenSz').value = btn.dataset.size;
    
    var p = document.getElementById('pdpPrice');
    p.textContent = '₹' + parseFloat(btn.dataset.price).toLocaleString('en-IN', {minimumFractionDigits:2});
    p.classList.remove('unset');
    p.classList.add('sale-price-active');
    
    var s = document.getElementById('stockMsg');
    s.style.display = 'inline-flex';
    s.className = 'o-stock'; // reset classes
    
    var stock = parseInt(btn.dataset.stock);
    var urgencyEl = document.getElementById('lowStockUrgency');
    var countEl = document.getElementById('lowStockCount');
    var submitBtns = document.querySelectorAll('#pdpForm button[type="submit"]');

    if(stock > 10){
        s.innerHTML = '<i class="fas fa-check-circle"></i> In Stock';
        s.classList.add('o-stock-ok');
        if(urgencyEl) urgencyEl.style.display = 'none';
        submitBtns.forEach(function(b) { b.disabled = false; b.style.opacity = '1'; });
    } else if(stock > 0){
        s.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Only ' + stock + ' left';
        s.classList.add('o-stock-low');
        if(urgencyEl) {
            urgencyEl.style.display = 'block';
            if(countEl) countEl.textContent = stock;
        }
        submitBtns.forEach(function(b) { b.disabled = false; b.style.opacity = '1'; });
    } else {
        s.innerHTML = '<i class="fas fa-times-circle"></i> Out of Stock';
        s.classList.add('o-stock-out');
        if(urgencyEl) urgencyEl.style.display = 'none';
        submitBtns.forEach(function(b) { b.disabled = true; b.style.opacity = '0.5'; });
    }
}

function adjQ(d){
    var i = document.getElementById('qtyInp');
    var val = parseInt(i.value) || 1;
    var max = parseInt(i.getAttribute('max')) || 10;
    var min = parseInt(i.getAttribute('min')) || 1;
    
    var newVal = val + d;
    if(newVal >= min && newVal <= max) {
        i.value = newVal;
    }
}

function togAcc(id){
    var item = document.getElementById(id);
    var body = item.querySelector('.o-acc-body');
    var btn = item.querySelector('.o-acc-trigger');
    
    if(item.classList.contains('open')){
        body.style.maxHeight = '0';
        item.classList.remove('open');
        btn.setAttribute('aria-expanded', 'false');
    } else {
        body.style.maxHeight = body.scrollHeight + 'px';
        item.classList.add('open');
        btn.setAttribute('aria-expanded', 'true');
    }
}

// Retro rating stars hover & click logic
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.retro-stars-input .retro-star');
    const input = document.getElementById('ratingInput');
    
    if (stars.length > 0 && input) {
        stars.forEach(star => {
            // Hover in
            star.addEventListener('mouseover', function() {
                const val = parseInt(this.dataset.value);
                highlightStars(val, true);
            });
            
            // Hover out
            star.addEventListener('mouseout', function() {
                const currentVal = parseInt(input.value) || 0;
                highlightStars(currentVal, false);
            });
            
            // Click
            star.addEventListener('click', function() {
                const val = parseInt(this.dataset.value);
                input.value = val;
                highlightStars(val, false);
            });
        });

        function highlightStars(val, isHover) {
            stars.forEach((star, index) => {
                if (index < val) {
                    star.textContent = '✦';
                    star.style.color = isHover ? 'var(--text)' : 'var(--accent)';
                    star.style.transform = isHover ? 'scale(1.2)' : 'scale(1)';
                } else {
                    star.textContent = '✧';
                    star.style.color = 'var(--text-muted)';
                    star.style.transform = 'scale(1)';
                }
            });
        }
        
        // Init state
        highlightStars(0, false);
    }
});

// Initialize open accordions
document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.o-acc-item.open .o-acc-body').forEach(function(b){
        b.style.maxHeight = b.scrollHeight + 'px';
    });
    
    // Prevent form submission if size not selected
    var form = document.getElementById('pdpForm');
    if(form){
        form.addEventListener('submit', function(e){
            if(!document.getElementById('hiddenSz').value){
                e.preventDefault();
                alert('Please select a size first.');
            }
        });
    }
});
</script>
@endsection