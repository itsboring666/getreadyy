@extends('layouts.front')
@section('title', 'Checkout | GET READY')

@section('content')

<div class="o-breadcrumb">
    <div class="o-breadcrumb-inner">
        <a href="{{ url('/') }}">Home</a> <span class="sep">/</span> 
        <a href="{{ route('cart') }}">Cart</a> <span class="sep">/</span> 
        <span class="current">Checkout</span>
    </div>
</div>

<div class="o-cart-layout">
    <div style="grid-column: 1 / -1;">
        <h1 style="font-family:var(--font-heading); font-size:28px; font-weight:700; color:var(--text); margin-bottom:8px;">Secure Checkout</h1>
        <p style="color:var(--text-secondary); margin-bottom:24px;">Please enter your shipping and payment details.</p>
    </div>

    @if($items->count() > 0)
    
    @if($errors->has('cashfree'))
        <div style="grid-column: 1 / -1; padding: 16px; background: #1a0808; border: 1px solid #7f1d1d; color: #fca5a5; border-radius: var(--radius); margin-bottom: 24px;">
            <strong>Error:</strong> {{ $errors->first('cashfree') }}
        </div>
    @endif
    @if($errors->has('msg'))
        <div style="grid-column: 1 / -1; padding: 16px; background: #1a0808; border: 1px solid #7f1d1d; color: #fca5a5; border-radius: var(--radius); margin-bottom: 24px;">
            <strong>Error:</strong> {{ $errors->first('msg') }}
        </div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST" class="o-cart-layout" style="grid-column: 1 / -1; display:contents;">
        @csrf

        {{-- Left Column: Form --}}
        <div style="grid-column: span 8;">
            <div style="background:#161616; border:1px solid var(--border); border-radius:var(--radius); padding:32px; margin-bottom:24px;">
                <h2 style="font-family:var(--font-heading); font-size:20px; font-weight:600; margin-bottom:20px; border-bottom:1px solid var(--border); padding-bottom:12px;">Contact Information</h2>
                
                <div class="o-form-group">
                    <label class="o-form-label" for="email">Email Address <span style="color:var(--danger);">*</span></label>
                    <input type="email" id="email" name="email" class="o-form-input @error('email') border-red-500 @enderror" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                    @error('email') <div style="color:var(--danger); font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                </div>
                
                <div class="o-form-group" style="margin-top:16px;">
                    <label class="o-form-label" for="phone">Phone Number <span style="color:var(--danger);">*</span></label>
                    <input type="tel" id="phone" name="phone" class="o-form-input @error('phone') border-red-500 @enderror" value="{{ old('phone', auth()->user()->phone ?? '') }}" required>
                    @error('phone') <div style="color:var(--danger); font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                </div>
            </div>

            <div style="background:#161616; border:1px solid var(--border); border-radius:var(--radius); padding:32px; margin-bottom:24px;">
                <h2 style="font-family:var(--font-heading); font-size:20px; font-weight:600; margin-bottom:20px; border-bottom:1px solid var(--border); padding-bottom:12px;">Shipping Address</h2>
                
                @if(isset($addresses) && $addresses->count() > 0)
                <div style="margin-bottom: 24px; padding: 20px; background: var(--bg); border: 1px solid var(--border); border-radius: var(--radius);">
                    <label class="o-form-label" for="saved_address_id" style="font-weight: 700; font-size: 11px; letter-spacing: 0.1em; color: var(--text);">USE SAVED COORDINATES</label>
                    <div style="position: relative; margin-top: 8px;">
                        <select id="saved_address_id" style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); background: #1a1a1a; color: var(--text); font-family: var(--font); font-size: 14px; outline: none; appearance: none; cursor: pointer;">
                            <option value="">-- Enter a new address --</option>
                            @foreach($addresses as $addr)
                                <option value="{{ $addr->id }}" 
                                        data-name="{{ $addr->name }}"
                                        data-phone="{{ $addr->phone }}"
                                        data-address="{{ $addr->address }}"
                                        data-city="{{ $addr->city }}"
                                        data-state="{{ $addr->state }}"
                                        data-zip="{{ $addr->zip }}"
                                        {{ $addr->is_default ? 'selected' : '' }}>
                                    {{ strtoupper($addr->address_name) }} — {{ $addr->name }} ({{ $addr->city }}, {{ $addr->state }})
                                </option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); font-size: 12px; color: var(--text-secondary); pointer-events: none;"></i>
                    </div>
                </div>
                @endif

                <div class="o-form-group">
                    <label class="o-form-label" for="name">Full Name <span style="color:var(--danger);">*</span></label>
                    <input type="text" id="name" name="name" class="o-form-input @error('name') border-red-500 @enderror" value="{{ old('name', auth()->user()->name ?? '') }}" required>
                    @error('name') <div style="color:var(--danger); font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                </div>

                <div class="o-form-group" style="margin-top:16px;">
                    <label class="o-form-label" for="address">Street Address <span style="color:var(--danger);">*</span></label>
                    <textarea id="address" name="address" rows="2" class="o-form-input @error('address') border-red-500 @enderror" required>{{ old('address') }}</textarea>
                    @error('address') <div style="color:var(--danger); font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                </div>

                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px; margin-top:16px;">
                    <div class="o-form-group">
                        <label class="o-form-label" for="city">City <span style="color:var(--danger);">*</span></label>
                        <input type="text" id="city" name="city" class="o-form-input @error('city') border-red-500 @enderror" value="{{ old('city') }}" required>
                        @error('city') <div style="color:var(--danger); font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                    </div>
                    
                    <div class="o-form-group">
                        <label class="o-form-label" for="state">State <span style="color:var(--danger);">*</span></label>
                        <input type="text" id="state" name="state" class="o-form-input @error('state') border-red-500 @enderror" value="{{ old('state') }}" required>
                        @error('state') <div style="color:var(--danger); font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="o-form-group" style="margin-top:16px; width:50%;">
                    <label class="o-form-label" for="zip">ZIP / Postal Code <span style="color:var(--danger);">*</span></label>
                    <input type="text" id="zip" name="zip" class="o-form-input @error('zip') border-red-500 @enderror" value="{{ old('zip') }}" required>
                    @error('zip') <div style="color:var(--danger); font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                </div>

                <div id="save_address_wrapper" style="margin-top: 24px; padding-top: 16px; border-top: 1px dashed var(--border); display: flex; flex-direction: column; gap: 12px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" id="save_address" name="save_address" value="1" style="width: 18px; height: 18px; accent-color: var(--primary); cursor: pointer;">
                        <span style="font-family: var(--font); font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text);">Save to my Address Book</span>
                    </label>
                    <div id="address_name_wrapper" style="display: none; margin-left: 26px;">
                        <label class="o-form-label" for="address_name" style="font-size: 11px; margin-bottom: 4px;">Address Designation / Tag</label>
                        <input type="text" id="address_name" name="address_name" placeholder="e.g. Home, Work" value="Home" class="o-form-input" style="width: 200px; padding: 8px 12px; font-size: 12px;">
                    </div>
                </div>
            </div>

            <div style="background:var(--white); border:1px solid var(--border); border-radius:var(--radius); padding:32px;">
                <h2 style="font-family:var(--font-heading); font-size:20px; font-weight:600; margin-bottom:20px; border-bottom:1px solid var(--border); padding-bottom:12px;">Payment Method</h2>
                
                <label style="display:flex; align-items:center; gap:12px; padding:16px; border:1px solid var(--primary); border-radius:var(--radius); background:rgba(0,0,0,0.02); cursor:pointer; margin-bottom:12px;">
                    <input type="radio" name="payment_method" value="razorpay" checked style="accent-color:var(--primary); width:18px; height:18px;">
                    <div style="display:flex; flex-direction:column;">
                        <span style="font-weight:600; color:var(--text);">Secure Online Payment (Razorpay)</span>
                        <span style="font-size:13px; color:var(--text-secondary);">Pay securely via UPI, Credit/Debit Card, NetBanking, or Wallets.</span>
                    </div>
                </label>

                <label style="display:flex; align-items:center; gap:12px; padding:16px; border:1px solid var(--border); border-radius:var(--radius); cursor:pointer;">
                    <input type="radio" name="payment_method" value="cod" style="accent-color:var(--primary); width:18px; height:18px;">
                    <div style="display:flex; flex-direction:column;">
                        <span style="font-weight:600; color:var(--text);">Cash on Delivery (COD)</span>
                        <span style="font-size:13px; color:var(--text-secondary);">Pay with cash upon delivery of your order.</span>
                    </div>
                </label>
                @error('payment_method') <div style="color:var(--danger); font-size:12px; margin-top:8px;">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- Right Column: Order Summary --}}
        <aside class="o-order-summary" style="height:fit-content; position:sticky; top:24px;">
            <h3 style="margin-bottom:16px; padding-bottom:12px; border-bottom:1px solid var(--border);">Order Summary</h3>
            
            
            

            <div style="margin-bottom:24px;">
                @foreach($items as $item)
                    @php
                        $product = $item->product;
                        $price = $item->unit_price ?? 0;
                        $total = $price * $item->quantity;
                    @endphp
                    <div style="display:flex; gap:12px; margin-bottom:16px;">
                        <div style="width:60px; height:80px; position:relative; border:1px solid var(--border); border-radius:4px; overflow:hidden;">
                            <img src="{{ get_storage_url($product->image) }}" alt="{{ $product->name }}" style="width:100%; height:100%; object-fit:cover;">
                            <span style="position:absolute; top:-6px; right:-6px; background:var(--primary); color:var(--white); font-size:11px; width:20px; height:20px; display:flex; align-items:center; justify-content:center; text-align:center; border-radius:50%; font-weight:bold;">{{ $item->quantity }}</span>
                        </div>
                        <div style="flex:1; display:flex; flex-direction:column; justify-content:center;">
                            <span style="font-weight:600; font-size:14px; color:var(--text);">{{ $product->name }}</span>
                            <span style="font-size:13px; color:var(--text-secondary);">Size: {{ $item->size }}</span>
                        </div>
                        <div style="font-weight:600; font-size:14px; color:var(--text); display:flex; align-items:center;">
                            ₹{{ number_format($total, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Coupon Section --}}
            <div style="margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid var(--border);">
                @if($couponCode)
                    <div style="background: rgba(83,100,81,0.05); padding: 12px; border: 1px dashed var(--primary); display: flex; justify-content: space-between; align-items: center; border-radius: var(--radius);">
                        <div>
                            <span style="font-weight: bold; color: var(--primary); font-family: monospace;">{{ $couponCode }}</span> applied
                        </div>
                        <button type="submit" name="action" value="remove_coupon" style="background: none; border: none; color: var(--danger); cursor: pointer; font-size: 12px; font-weight: bold; font-family: var(--font);">Remove</button>
                    </div>
                @else
                    <div style="display: flex; gap: 8px;">
                        <input type="text" name="coupon_code" placeholder="PROMO CODE" class="o-form-input" style="flex: 1; text-transform: uppercase; font-family: var(--font); font-size: 12px; padding: 10px;">
                        <button type="submit" name="action" value="apply_coupon" class="o-btn o-btn-primary" style="padding: 10px 16px; font-size: 11px; font-weight: bold;">Apply</button>
                    </div>
                @endif
            </div>

            <div class="o-summary-row">
                <span>Subtotal</span>
                <span style="font-weight:600;">₹{{ number_format($subtotal, 2) }}</span>
            </div>
            
            <div class="o-summary-row">
                <span>Shipping</span>
                <span>{{ $shipping > 0 ? '₹' . number_format($shipping, 2) : 'Free' }}</span>
            </div>

            @if($discountAmount > 0)
            <div class="o-summary-row" style="color: var(--accent);">
                <span>Discount</span>
                <span>-₹{{ number_format($discountAmount, 2) }}</span>
            </div>
            @endif
            
            <div class="o-summary-divider"></div>
            
            <div class="o-summary-row total" style="margin-bottom:24px;">
                <span>Total</span>
                <span style="color:var(--accent); font-size:24px;">₹{{ number_format($grandTotal, 2) }}</span>
            </div>
            
            <button type="submit" class="o-btn o-btn-primary o-btn-full o-btn-lg">
                <i class="fas fa-lock" aria-hidden="true" style="margin-right:8px;"></i> Pay Now
            </button>
            
            <div style="margin-top:16px; text-align:center; font-size:12px; color:var(--text-secondary);">
                By proceeding, you agree to our Terms of Service and Privacy Policy.
            </div>
        </aside>
    </form>

    @else
    <div class="o-empty" style="grid-column: 1 / -1; background:#161616; border:1px solid var(--border); border-radius:var(--radius-lg);">
        <i class="fas fa-shopping-cart o-empty-icon" aria-hidden="true"></i>
        <h3>Your cart is empty</h3>
        <p>You cannot proceed to checkout without any items.</p>
        <a href="{{ route('products.all') }}" class="o-btn o-btn-primary" style="margin-top:16px;">Return to Shop</a>
    </div>
    @endif
</div>

<style>
@media (max-width: 768px) {
    .o-cart-layout form.o-cart-layout {
        display: flex !important;
        flex-direction: column;
    }
    .o-cart-layout [style*="grid-column: span 8"] {
        grid-column: 1 / -1 !important;
    }
    .o-order-summary {
        position: static !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const radios = document.querySelectorAll('input[name="payment_method"]');
    const submitBtn = document.querySelector('button[type="submit"]');
    const labels = document.querySelectorAll('label:has(input[name="payment_method"])');

    function updatePaymentUI() {
        radios.forEach(function(radio) {
            const label = radio.closest('label');
            if (radio.checked) {
                label.style.borderColor = 'var(--primary)';
                label.style.background = 'rgba(83,100,81,0.04)';
            } else {
                label.style.borderColor = 'var(--border)';
                label.style.background = 'transparent';
            }
        });

        const selected = document.querySelector('input[name="payment_method"]:checked');
        if (submitBtn && selected) {
            if (selected.value === 'cod') {
                submitBtn.innerHTML = '<i class="fas fa-truck" aria-hidden="true" style="margin-right:8px;"></i> Place Order (COD)';
            } else {
                submitBtn.innerHTML = '<i class="fas fa-lock" aria-hidden="true" style="margin-right:8px;"></i> Pay Now';
            }
        }
    }

    radios.forEach(function(radio) {
        radio.addEventListener('change', updatePaymentUI);
    });

    updatePaymentUI();

    // Saved Address Autofill Logic
    const savedAddressSelect = document.getElementById('saved_address_id');
    const nameInput = document.getElementById('name');
    const phoneInput = document.getElementById('phone');
    const addressInput = document.getElementById('address');
    const cityInput = document.getElementById('city');
    const stateInput = document.getElementById('state');
    const zipInput = document.getElementById('zip');
    const saveAddressWrapper = document.getElementById('save_address_wrapper');
    const saveAddressCheckbox = document.getElementById('save_address');
    const addressNameWrapper = document.getElementById('address_name_wrapper');

    function handleAddressAutofill() {
        if (!savedAddressSelect) return;
        const selectedOption = savedAddressSelect.options[savedAddressSelect.selectedIndex];
        
        if (selectedOption && selectedOption.value !== "") {
            // Populate fields
            nameInput.value = selectedOption.getAttribute('data-name') || '';
            phoneInput.value = selectedOption.getAttribute('data-phone') || '';
            addressInput.value = selectedOption.getAttribute('data-address') || '';
            cityInput.value = selectedOption.getAttribute('data-city') || '';
            stateInput.value = selectedOption.getAttribute('data-state') || '';
            zipInput.value = selectedOption.getAttribute('data-zip') || '';
            
            // Hide save address checkbox since it is already saved
            if (saveAddressWrapper) {
                saveAddressWrapper.style.display = 'none';
                saveAddressCheckbox.checked = false;
                if (addressNameWrapper) addressNameWrapper.style.display = 'none';
            }
        } else {
            // Show save address checkbox
            if (saveAddressWrapper) {
                saveAddressWrapper.style.display = 'flex';
            }
        }
    }

    if (savedAddressSelect) {
        savedAddressSelect.addEventListener('change', handleAddressAutofill);
        // Trigger initially in case default is selected
        handleAddressAutofill();
    }

    if (saveAddressCheckbox) {
        saveAddressCheckbox.addEventListener('change', function() {
            if (this.checked) {
                addressNameWrapper.style.display = 'block';
            } else {
                addressNameWrapper.style.display = 'none';
            }
        });
    }
});
</script>

@endsection