@extends('layouts.front')
@section('title', 'Edit Profile | GET READY')

@section('content')

<div class="gr-wardrobe" style="padding: 60px 24px 100px;">
    <div style="max-width: 800px; margin: 0 auto;">
        
        <div style="margin-bottom: 24px;">
            <a href="{{ route('profile.show') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em;">
                <i class="fas fa-arrow-left" style="margin-right: 8px;"></i> BACK TO DOSSIER
            </a>
        </div>

        <div style="margin-bottom: 40px;">
            <h1 style="font-family: var(--font-heading); font-size: 36px; font-weight: 700; color: var(--text); margin-bottom: 8px;">UPDATE CLEARANCE</h1>
            <p style="color: var(--text-secondary); font-family: var(--font); font-size: 14px; text-transform: uppercase; letter-spacing: 0.05em;">Modify your personnel file data.</p>
        </div>

        <div style="background: #161616; border: 1px solid var(--border); padding: 40px;">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px;">
                    
                    {{-- Name --}}
                    <div style="grid-column: 1 / -1;">
                        <label for="name" style="display: block; font-family: var(--font); font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text); margin-bottom: 8px; font-weight: 700;">Full Name <span style="color: var(--danger);">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 12px 16px; border: 1px solid var(--border-light); border-radius: 0; background: var(--bg); font-family: var(--font); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--text)'" onblur="this.style.borderColor='var(--border-light)'">
                        @error('name') <div style="color: var(--danger); font-size: 12px; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" style="display: block; font-family: var(--font); font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text); margin-bottom: 8px; font-weight: 700;">Email Address <span style="color: var(--danger);">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 12px 16px; border: 1px solid var(--border-light); border-radius: 0; background: var(--bg); font-family: var(--font); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--text)'" onblur="this.style.borderColor='var(--border-light)'">
                        @error('email') <div style="color: var(--danger); font-size: 12px; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label for="phone" style="display: block; font-family: var(--font); font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text); margin-bottom: 8px; font-weight: 700;">Phone Number</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); border-radius: 0; background: #1a1a1a; color: var(--text); font-family: var(--font); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'" placeholder="e.g. 9876543210">
                        @error('phone') <div style="color: var(--danger); font-size: 12px; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>

                    {{-- DOB --}}
                    <div>
                        <label for="dob" style="display: block; font-family: var(--font); font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text); margin-bottom: 8px; font-weight: 700;">Date of Birth</label>
                        <input type="date" id="dob" name="dob" value="{{ old('dob', $user->dob) }}" style="width: 100%; padding: 12px 16px; border: 1px solid var(--border); border-radius: 0; background: #1a1a1a; color: var(--text); font-family: var(--font); font-size: 14px; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--primary)'" onblur="this.style.borderColor='var(--border)'">
                        @error('dob') <div style="color: var(--danger); font-size: 12px; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>

                    {{-- Gender --}}
                    <div>
                        <label for="gender" style="display: block; font-family: var(--font); font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text); margin-bottom: 8px; font-weight: 700;">Gender</label>
                        <div style="position: relative;">
                            <select id="gender" name="gender" style="width: 100%; padding: 12px 16px; border: 1px solid var(--border-light); border-radius: 0; background: var(--bg); font-family: var(--font); font-size: 14px; appearance: none; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--text)'" onblur="this.style.borderColor='var(--border-light)'">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <i class="fas fa-chevron-down" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); font-size: 12px; color: var(--text-secondary); pointer-events: none;"></i>
                        </div>
                        @error('gender') <div style="color: var(--danger); font-size: 12px; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>

                    {{-- Address --}}
                    <div style="grid-column: 1 / -1;">
                        <label for="address" style="display: block; font-family: var(--font); font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text); margin-bottom: 8px; font-weight: 700;">Shipping Address</label>
                        <textarea id="address" name="address" rows="3" style="width: 100%; padding: 12px 16px; border: 1px solid var(--border-light); border-radius: 0; background: var(--bg); font-family: var(--font); font-size: 14px; outline: none; transition: border-color 0.2s; resize: vertical;" onfocus="this.style.borderColor='var(--text)'" onblur="this.style.borderColor='var(--border-light)'">{{ old('address', $user->address) }}</textarea>
                        @error('address') <div style="color: var(--danger); font-size: 12px; margin-top: 4px;">{{ $message }}</div> @enderror
                    </div>

                </div>

                <div style="display: flex; gap: 16px; align-items: center; justify-content: flex-end; padding-top: 32px; border-top: 1px solid var(--border-light);">
                    <a href="{{ route('profile.show') }}" style="color: var(--text-secondary); font-family: var(--font); font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; text-decoration: none;">CANCEL</a>
                    <button type="submit" class="gr-hero-btn-primary" style="background: var(--text); padding: 16px 32px; font-size: 12px;">SAVE CHANGES →</button>
                </div>
            </form>
        </div>

    </div>
</div>

<style>
@media (max-width: 600px) {
    form > div > div {
        grid-column: 1 / -1 !important;
    }
}
</style>

@endsection