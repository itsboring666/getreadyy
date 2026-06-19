@extends('layouts.front')
@section('title', 'Reset Password | GET READY')

@section('content')

<div class="o-container" style="max-width:500px; margin: 80px auto; padding: 40px 20px;">
    
    

    <div style="text-align:center; margin-bottom: 40px;">
        <h1 style="font-family:var(--font-heading); font-size:36px; font-weight:700; letter-spacing:-0.5px; margin-bottom:8px;">Reset Password</h1>
        <p style="color:var(--text-secondary); font-size:15px;">Enter your email and create a new secure password.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="o-form">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="o-form-group">
            <label for="email" class="o-form-label">Email Address <span style="color:var(--danger);">*</span></label>
            <input type="email" id="email" name="email" class="o-form-input @error('email') is-invalid @enderror" value="{{ old('email', $request->email) }}" required autofocus>
            @error('email') <div style="color:var(--danger); font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
        </div>

        <div class="o-form-group" style="margin-top:20px;">
            <label for="password" class="o-form-label">New Password <span style="color:var(--danger);">*</span></label>
            <input type="password" id="password" name="password" class="o-form-input @error('password') is-invalid @enderror" required placeholder="••••••••">
            @error('password') <div style="color:var(--danger); font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
        </div>

        <div class="o-form-group" style="margin-top:20px;">
            <label for="password_confirmation" class="o-form-label">Confirm New Password <span style="color:var(--danger);">*</span></label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="o-form-input" required placeholder="••••••••">
        </div>

        <button type="submit" class="o-btn o-btn-primary o-btn-full" style="margin-top:32px; padding:14px; font-size:16px;">
            Reset Password
        </button>
    </form>
</div>

@endsection
