@extends('layouts.front')
@section('title', 'Sign In | GET READY')

@section('content')

<div class="gr-wardrobe" style="padding: 60px 24px 100px;">
    <div style="max-width: 500px; margin: 0 auto;">
        
        <div style="margin-bottom: 32px; border-bottom: 3px double var(--text); padding-bottom: 16px; text-align: center;">
            <div style="font-family: var(--font); font-size: 10px; font-weight: 700; color: var(--accent); letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 8px;">Clearance Authorization // Vol. III</div>
            <h1 style="font-family: var(--font-heading); font-size: 32px; font-weight: 700; color: var(--text); margin: 0; letter-spacing: 0.05em;">SIGN IN</h1>
        </div>

        <div style="background: #161616; border: 1px solid var(--border); box-shadow: 5px 5px 0px rgba(153,27,27,0.35); padding: 40px; margin-bottom: 32px;">
            
            <div style="background: var(--bg); border: 1px dashed var(--text); padding: 16px; margin-bottom: 32px; font-family: monospace; font-size: 12px; line-height: 1.5; color: var(--text-secondary); text-align: center;">
                <span>LOT: OUTFIT-818 // SIGN IN PROTOCOL</span><br>
                <span>Clearance yields order tracking & fast checkout.</span>
            </div>

            <form method="POST" action="{{ route('login') }}" class="o-form">
                @csrf

                <div class="o-form-group">
                    <label for="email" class="o-form-label">Email Address <span style="color:var(--danger);">*</span></label>
                    <input type="email" id="email" name="email" class="o-form-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
                    @error('email') <div style="color:var(--danger); font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                </div>

                <div class="o-form-group">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 8px;">
                        <label for="password" class="o-form-label" style="margin-bottom:0;">Password <span style="color:var(--danger);">*</span></label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="font-size:11px; font-family: var(--font); color:var(--text-secondary); text-decoration:underline;">Forgot password?</a>
                        @endif
                    </div>
                    <input type="password" id="password" name="password" class="o-form-input @error('password') is-invalid @enderror" required placeholder="••••••••">
                    @error('password') <div style="color:var(--danger); font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                </div>

                <div style="display:flex; align-items:center;">
                    <input type="checkbox" id="remember_me" name="remember" style="accent-color:var(--accent); width:16px; height:16px; cursor:pointer;">
                    <label for="remember_me" style="margin-left:8px; font-size:12px; color:var(--text); cursor:pointer; font-family:var(--font); text-transform:uppercase; letter-spacing:0.05em; font-weight:700;">Keep me signed in</label>
                </div>

                <button type="submit" class="o-btn o-btn-full" style="margin-top: 32px; border: 1px solid var(--text); padding: 16px; font-size: 12px;">
                    SIGN IN →
                </button>
            </form>
        </div>

        <div style="text-align: center; font-family: monospace; font-size: 13px;">
            Don't have clearance? 
            <a href="{{ route('register') }}" style="color: var(--accent); font-weight: bold; text-decoration: underline; text-underline-offset: 4px;">Create an account</a>
        </div>

    </div>
</div>

@endsection