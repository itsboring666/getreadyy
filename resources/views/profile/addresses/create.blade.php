@extends('layouts.front')
@section('title', 'Add Address | GET READY')

@section('content')

<div class="gr-wardrobe" style="padding: 60px 24px 100px;">
    <div style="max-width: 800px; margin: 0 auto;">

        <div style="margin-bottom: 24px;">
            <a href="{{ route('addresses.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s;" onmouseover="this.style.color='var(--text)';" onmouseout="this.style.color='var(--text-secondary)';">
                <i class="fas fa-arrow-left"></i> BACK TO ADDRESS BOOK
            </a>
        </div>

        <div style="margin-bottom: 36px; border-bottom: 1px solid var(--border); padding-bottom: 20px;">
            <div style="font-family: var(--font); font-size: 10px; font-weight: 700; color: var(--primary); letter-spacing: 0.12em; text-transform: uppercase; margin-bottom: 8px;">ADDRESS BOOK // NEW ENTRY</div>
            <h1 style="font-family: var(--font-heading); font-size: 36px; font-weight: 700; color: var(--text); margin: 0; letter-spacing: 0.04em;">ADD COORDINATES</h1>
            <p style="color: var(--text-secondary); font-family: var(--font); font-size: 13px; text-transform: uppercase; letter-spacing: 0.06em; margin-top: 8px;">Register a new shipping destination.</p>
        </div>

        <div style="background: #161616; border: 1px solid var(--border); box-shadow: 5px 5px 0px rgba(153,27,27,0.3); padding: 40px;">
            <form method="POST" action="{{ route('addresses.store') }}" class="o-form">
                @csrf

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px;">

                    {{-- Address Designation --}}
                    <div style="grid-column: 1 / -1;">
                        <label for="address_name" style="display: block; font-family: var(--font); font-size: 10px; text-transform: uppercase; letter-spacing: 0.12em; color: var(--text-secondary); margin-bottom: 8px; font-weight: 700;">
                            Address Tag <span style="color: var(--primary);">*</span>
                        </label>
                        <input type="text" id="address_name" name="address_name" value="{{ old('address_name', 'Home') }}" required placeholder="e.g. Home, Work, Office"
                               style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); background: #1a1a1a; color: var(--text); font-family: var(--font); font-size: 13px; outline: none; transition: border-color 0.2s;"
                               onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                        @error('address_name') <div style="color: var(--danger); font-size: 11px; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>

                    {{-- Recipient Name --}}
                    <div style="grid-column: 1 / -1;">
                        <label for="name" style="display: block; font-family: var(--font); font-size: 10px; text-transform: uppercase; letter-spacing: 0.12em; color: var(--text-secondary); margin-bottom: 8px; font-weight: 700;">
                            Recipient Name <span style="color: var(--primary);">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Full name of recipient"
                               style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); background: #1a1a1a; color: var(--text); font-family: var(--font); font-size: 13px; outline: none; transition: border-color 0.2s;"
                               onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                        @error('name') <div style="color: var(--danger); font-size: 11px; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>

                    {{-- Phone --}}
                    <div style="grid-column: 1 / -1;">
                        <label for="phone" style="display: block; font-family: var(--font); font-size: 10px; text-transform: uppercase; letter-spacing: 0.12em; color: var(--text-secondary); margin-bottom: 8px; font-weight: 700;">
                            Phone Number <span style="color: var(--primary);">*</span>
                        </label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="e.g. 9876543210"
                               style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); background: #1a1a1a; color: var(--text); font-family: var(--font); font-size: 13px; outline: none; transition: border-color 0.2s;"
                               onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                        @error('phone') <div style="color: var(--danger); font-size: 11px; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>

                    {{-- Street Address --}}
                    <div style="grid-column: 1 / -1;">
                        <label for="address" style="display: block; font-family: var(--font); font-size: 10px; text-transform: uppercase; letter-spacing: 0.12em; color: var(--text-secondary); margin-bottom: 8px; font-weight: 700;">
                            Street Address <span style="color: var(--primary);">*</span>
                        </label>
                        <textarea id="address" name="address" rows="3" required placeholder="Apartment, suite, unit, street address..."
                                  style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); background: #1a1a1a; color: var(--text); font-family: var(--font); font-size: 13px; outline: none; transition: border-color 0.2s; resize: vertical;"
                                  onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">{{ old('address') }}</textarea>
                        @error('address') <div style="color: var(--danger); font-size: 11px; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>

                    {{-- City --}}
                    <div>
                        <label for="city" style="display: block; font-family: var(--font); font-size: 10px; text-transform: uppercase; letter-spacing: 0.12em; color: var(--text-secondary); margin-bottom: 8px; font-weight: 700;">
                            City <span style="color: var(--primary);">*</span>
                        </label>
                        <input type="text" id="city" name="city" value="{{ old('city') }}" required
                               style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); background: #1a1a1a; color: var(--text); font-family: var(--font); font-size: 13px; outline: none; transition: border-color 0.2s;"
                               onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                        @error('city') <div style="color: var(--danger); font-size: 11px; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>

                    {{-- State --}}
                    <div>
                        <label for="state" style="display: block; font-family: var(--font); font-size: 10px; text-transform: uppercase; letter-spacing: 0.12em; color: var(--text-secondary); margin-bottom: 8px; font-weight: 700;">
                            State <span style="color: var(--primary);">*</span>
                        </label>
                        <input type="text" id="state" name="state" value="{{ old('state') }}" required
                               style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); background: #1a1a1a; color: var(--text); font-family: var(--font); font-size: 13px; outline: none; transition: border-color 0.2s;"
                               onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                        @error('state') <div style="color: var(--danger); font-size: 11px; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>

                    {{-- ZIP --}}
                    <div>
                        <label for="zip" style="display: block; font-family: var(--font); font-size: 10px; text-transform: uppercase; letter-spacing: 0.12em; color: var(--text-secondary); margin-bottom: 8px; font-weight: 700;">
                            ZIP / Postal Code <span style="color: var(--primary);">*</span>
                        </label>
                        <input type="text" id="zip" name="zip" value="{{ old('zip') }}" required placeholder="e.g. 600001"
                               style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); background: #1a1a1a; color: var(--text); font-family: var(--font); font-size: 13px; outline: none; transition: border-color 0.2s;"
                               onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                        @error('zip') <div style="color: var(--danger); font-size: 11px; margin-top: 5px;">{{ $message }}</div> @enderror
                    </div>

                    {{-- Default checkbox --}}
                    <div style="grid-column: 1 / -1; display: flex; align-items: center; gap: 10px; padding-top: 8px; border-top: 1px dashed var(--border); margin-top: 8px;">
                        <input type="checkbox" id="is_default" name="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}
                               style="width: 18px; height: 18px; accent-color: var(--primary); cursor: pointer; flex-shrink: 0;">
                        <label for="is_default" style="font-family: var(--font); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--text-secondary); cursor: pointer;">
                            Set as default delivery destination
                        </label>
                    </div>

                </div>

                <div style="display: flex; gap: 16px; align-items: center; justify-content: flex-end; padding-top: 28px; border-top: 1px solid var(--border);">
                    <a href="{{ route('addresses.index') }}" style="color: var(--text-secondary); font-family: var(--font); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--text)';" onmouseout="this.style.color='var(--text-secondary)';">CANCEL</a>
                    <button type="submit" class="gr-hero-btn-primary" style="padding: 14px 32px; font-size: 11px;">SAVE COORDINATES →</button>
                </div>
            </form>
        </div>

    </div>
</div>

<style>
@media (max-width: 600px) {
    form > div > div { grid-column: 1 / -1 !important; padding-top: 0 !important; }
}
</style>

@endsection
