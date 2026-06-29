@extends('layouts.front')
@section('title', 'Create Account | GET READY')

@section('content')

<div class="gr-wardrobe" style="padding: 60px 24px 100px;">
    <div style="max-width: 500px; margin: 0 auto;">
        
        <div style="margin-bottom: 32px; border-bottom: 3px double var(--text); padding-bottom: 16px; text-align: center;">
            <div style="font-family: var(--font); font-size: 10px; font-weight: 700; color: var(--accent); letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 8px;">Clearance Request // Vol. III</div>
            <h1 style="font-family: var(--font-heading); font-size: 32px; font-weight: 700; color: var(--text); margin: 0; letter-spacing: 0.05em;">CREATE ACCOUNT</h1>
        </div>

        <div style="background: #161616; border: 1px solid var(--border); box-shadow: 5px 5px 0px rgba(153,27,27,0.35); padding: 40px; margin-bottom: 32px;">
            
            <div style="background: var(--bg); border: 1px dashed var(--text); padding: 16px; margin-bottom: 32px; font-family: monospace; font-size: 12px; line-height: 1.5; color: var(--text-secondary); text-align: center;">
                <span>LOT: GET READY // REGISTRATION PROTOCOL</span><br>
                <span>Clearance yields order tracking & fast checkout.</span>
            </div>

            @if($errors->any())
                <div style="background: #1a0808; border: 1px solid #7f1d1d; color: #fca5a5; padding: 16px; margin-bottom: 24px; font-family: var(--font); font-size: 13px;">
                    <strong>ERRORS DETECTED:</strong>
                    <ul style="margin: 8px 0 0 16px; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="o-form" enctype="multipart/form-data">
                @csrf

                <div style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <div class="o-form-group">
                        <label for="name" class="o-form-label">Full Name <span style="color:var(--danger);">*</span></label>
                        <input type="text" id="name" name="name" class="o-form-input @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus placeholder="John Doe">
                        @error('name') <div style="color:var(--danger); font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                    </div>

                    <div class="o-form-group">
                        <label for="email" class="o-form-label">Email Address <span style="color:var(--danger);">*</span></label>
                        <input type="email" id="email" name="email" class="o-form-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="you@example.com">
                        @error('email') <div style="color:var(--danger); font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                    </div>

                    <div class="o-form-group">
                        <label for="phone" class="o-form-label">Phone Number (10 Digits) <span style="color:var(--danger);">*</span></label>
                        <input type="tel" id="phone" name="phone" class="o-form-input @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required placeholder="e.g. 9876543210" pattern="[0-9]{10}" title="Must be exactly 10 digits">
                        @error('phone') <div style="color:var(--danger); font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                    </div>

                    <div class="o-form-group">
                        <label for="profile_picture" class="o-form-label">Profile Picture <span style="color:var(--text-secondary); font-size:9px; font-weight:normal;">(Optional)</span></label>
                        <input type="file" id="profile_picture" name="profile_picture" class="o-form-input @error('profile_picture') is-invalid @enderror" accept="image/*" style="padding: 11px 16px;">
                        @error('profile_picture') <div style="color:var(--danger); font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                    </div>

                    <div class="o-form-group">
                        <label for="password" class="o-form-label">Password <span style="color:var(--danger);">*</span></label>
                        <div style="position: relative;">
                            <input type="password" id="password" name="password" class="o-form-input @error('password') is-invalid @enderror" required placeholder="••••••••" style="padding-right: 40px;">
                            <button type="button" onclick="const p = document.getElementById('password'); const i = this.querySelector('i'); if(p.type === 'password'){ p.type = 'text'; i.classList.replace('fa-eye', 'fa-eye-slash'); } else { p.type = 'password'; i.classList.replace('fa-eye-slash', 'fa-eye'); }" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 0;">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                        @error('password') <div style="color:var(--danger); font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                        <div style="font-size:11px; color:var(--text-secondary); margin-top:6px; font-family: monospace;">Min 8 chars. Must contain 1 uppercase, 1 lowercase, 1 number.</div>
                    </div>

                    <div class="o-form-group">
                        <label for="password_confirmation" class="o-form-label">Confirm Password <span style="color:var(--danger);">*</span></label>
                        <div style="position: relative;">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="o-form-input" required placeholder="••••••••" style="padding-right: 40px;">
                            <button type="button" onclick="const p = document.getElementById('password_confirmation'); const i = this.querySelector('i'); if(p.type === 'password'){ p.type = 'text'; i.classList.replace('fa-eye', 'fa-eye-slash'); } else { p.type = 'password'; i.classList.replace('fa-eye-slash', 'fa-eye'); }" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 0;">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>

                </div>

                <button type="submit" class="o-btn o-btn-full" style="margin-top: 32px; border: 1px solid var(--text); padding: 16px; font-size: 12px;">
                    SUBMIT REGISTRATION →
                </button>
            </form>
        </div>

        <div style="text-align: center; font-family: monospace; font-size: 13px;">
            Already have clearance? 
            <a href="{{ route('login') }}" style="color: var(--accent); font-weight: bold; text-decoration: underline; text-underline-offset: 4px;">Sign In</a>
        </div>

    </div>
</div>

@endsection