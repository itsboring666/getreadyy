@extends('layouts.front')
@section('title', 'Verify OTP | GET READY')

@section('content')

<div class="o-container" style="max-width:500px; margin: 80px auto; padding: 40px 20px;">
    

    


    <div style="text-align:center; margin-bottom: 40px;">
        <h1 style="font-family:var(--font-heading); font-size:36px; font-weight:700; letter-spacing:-0.5px; margin-bottom:8px;">Verify Your Account</h1>
        <p style="color:var(--text-secondary); font-size:15px;">We have sent a One-Time Password (OTP) to your email address.</p>
    </div>

    <form method="POST" action="{{ route('otp.verify') }}" class="o-form">
        @csrf
        <input type="hidden" name="email" value="{{ request('email') ?? $email ?? '' }}">

        <div class="o-form-group">
            <label for="otp" class="o-form-label" style="text-align:center; display:block;">Enter 6-Digit OTP</label>
            <input type="text" id="otp" name="otp" class="o-form-input @error('otp') is-invalid @enderror" style="text-align:center; font-size:24px; letter-spacing:8px; font-family:monospace;" required autofocus maxlength="6" autocomplete="off">
            @error('otp') <div style="color:var(--danger); font-size:12px; margin-top:4px; text-align:center;">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="o-btn o-btn-primary o-btn-full" style="margin-top:32px; padding:14px; font-size:16px;">
            Verify Account
        </button>
    </form>

    <div style="text-align:center; margin-top:32px; padding-top:24px; border-top:1px solid var(--border);">
        <p style="color:var(--text-secondary); font-size:14px;">
            Didn't receive the code? 
            <form action="{{ route('otp.resend', ['email' => request('email') ?? $email ?? '']) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="color:var(--primary); font-weight:600; text-decoration:underline; text-underline-offset:2px; background:none; border:none; cursor:pointer; padding:0; font-size:14px;">Resend OTP</button>
            </form>
        </p>
    </div>
</div>

@endsection
