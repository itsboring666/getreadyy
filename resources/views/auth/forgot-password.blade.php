@extends('layouts.front')
@section('title', 'Forgot Password | GET READY')

@section('content')

<div class="o-container" style="max-width:500px; margin: 80px auto; padding: 40px 20px;">
    
    
    
    

    <div style="text-align:center; margin-bottom: 40px;">
        <h1 style="font-family:var(--font-heading); font-size:36px; font-weight:700; letter-spacing:-0.5px; margin-bottom:8px;">Forgot Password</h1>
        <p style="color:var(--text-secondary); font-size:15px;">Enter your email address and we will send you a password reset link.</p>
    </div>

    <form method="POST" action="{{ route('password.email') }}" class="o-form">
        @csrf

        <div class="o-form-group">
            <label for="email" class="o-form-label">Email Address <span style="color:var(--danger);">*</span></label>
            <input type="email" id="email" name="email" class="o-form-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
            @error('email') <div style="color:var(--danger); font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="o-btn o-btn-primary o-btn-full" style="margin-top:32px; padding:14px; font-size:16px;">
            Email Password Reset Link
        </button>
    </form>

    <div style="text-align:center; margin-top:32px; padding-top:24px; border-top:1px solid var(--border);">
        <p style="color:var(--text-secondary); font-size:14px;">
            Remembered your password? 
            <a href="{{ route('login') }}" style="color:var(--primary); font-weight:600; text-decoration:underline; text-underline-offset:2px;">Sign In</a>
        </p>
    </div>
</div>

@endsection