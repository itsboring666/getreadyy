@extends('layouts.front')
@section('title', 'Your Profile | GET READY')

@section('content')

<div class="gr-wardrobe" style="padding: 60px 24px 100px;">
    <div style="max-width: 1000px; margin: 0 auto;">

        <div style="margin-bottom: 40px;">
            <h1 style="font-family: var(--font-heading); font-size: 36px; font-weight: 700; color: var(--text); margin-bottom: 8px;">PERSONNEL FILE</h1>
            <p style="color: var(--text-secondary); font-family: var(--font); font-size: 14px; text-transform: uppercase; letter-spacing: 0.05em;">Manage your identity and operational data.</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 3fr; gap: 32px;" class="profile-grid">

            {{-- Sidebar / Quick Links --}}
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="background: #161616; border: 1px solid var(--border); padding: 28px; text-align: center;">
                    <div style="width: 72px; height: 72px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: var(--font-heading); font-size: 30px; margin: 0 auto 14px;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h3 style="font-family: var(--font-heading); font-size: 20px; margin-bottom: 4px; color: var(--text);">{{ $user->name }}</h3>
                    <p style="font-family: var(--font); font-size: 11px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.1em;">{{ $user->email }}</p>
                </div>

                <a href="{{ route('profile.edit') }}" class="gr-hero-btn-primary" style="justify-content: center; padding: 14px; font-size: 11px;">
                    <i class="fas fa-user-edit" style="margin-right: 8px;"></i> UPDATE CLEARANCE
                </a>

                <a href="{{ route('cart') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; background: #161616; border: 1px solid var(--border); color: var(--text); text-decoration: none; font-family: var(--font); font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em; transition: border-color 0.2s, background 0.2s;" onmouseover="this.style.background='#1e1e1e'; this.style.borderColor='var(--primary)';" onmouseout="this.style.background='#161616'; this.style.borderColor='var(--border)';">
                    <span><i class="fas fa-shopping-cart" style="margin-right: 8px;"></i> Requisition Cart</span>
                    <i class="fas fa-chevron-right" style="color: var(--text-secondary);"></i>
                </a>

                <a href="{{ route('orders.index') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; background: #161616; border: 1px solid var(--border); color: var(--text); text-decoration: none; font-family: var(--font); font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em; transition: border-color 0.2s, background 0.2s;" onmouseover="this.style.background='#1e1e1e'; this.style.borderColor='var(--primary)';" onmouseout="this.style.background='#161616'; this.style.borderColor='var(--border)';">
                    <span><i class="fas fa-box" style="margin-right: 8px;"></i> Dispatch Log</span>
                    <i class="fas fa-chevron-right" style="color: var(--text-secondary);"></i>
                </a>

                <a href="{{ route('wishlist.index') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; background: #161616; border: 1px solid var(--border); color: var(--text); text-decoration: none; font-family: var(--font); font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em; transition: border-color 0.2s, background 0.2s;" onmouseover="this.style.background='#1e1e1e'; this.style.borderColor='var(--primary)';" onmouseout="this.style.background='#161616'; this.style.borderColor='var(--border)';">
                    <span><i class="fas fa-heart" style="margin-right: 8px;"></i> Wishlist</span>
                    <i class="fas fa-chevron-right" style="color: var(--text-secondary);"></i>
                </a>

                <a href="{{ route('addresses.index') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; background: #161616; border: 1px solid var(--border); color: var(--text); text-decoration: none; font-family: var(--font); font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em; transition: border-color 0.2s, background 0.2s;" onmouseover="this.style.background='#1e1e1e'; this.style.borderColor='var(--primary)';" onmouseout="this.style.background='#161616'; this.style.borderColor='var(--border)';">
                    <span><i class="fas fa-address-book" style="margin-right: 8px;"></i> Address Book</span>
                    <i class="fas fa-chevron-right" style="color: var(--text-secondary);"></i>
                </a>

                <form method="POST" action="{{ route('logout') }}" style="margin-top: 8px;">
                    @csrf
                    <button type="submit" style="width: 100%; display: flex; align-items: center; justify-content: center; padding: 14px; background: transparent; border: 1px solid var(--primary); color: var(--primary); font-family: var(--font); font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='var(--primary)'; this.style.color='#fff';" onmouseout="this.style.background='transparent'; this.style.color='var(--primary)';">
                        <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> TERMINATE SESSION
                    </button>
                </form>
            </div>

            {{-- Main Profile Details --}}
            <div style="background: #161616; border: 1px solid var(--border); padding: 40px;">
                <h2 style="font-family: var(--font-heading); font-size: 24px; margin-bottom: 32px; padding-bottom: 16px; border-bottom: 1px solid var(--border); color: var(--text);">IDENTIFICATION</h2>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">

                    <div>
                        <span style="display: block; font-family: var(--font); font-size: 10px; text-transform: uppercase; letter-spacing: 0.12em; color: var(--text-secondary); margin-bottom: 6px;">Full Name</span>
                        <span style="font-family: var(--font); font-size: 15px; font-weight: 600; color: var(--text);">{{ $user->name }}</span>
                    </div>

                    <div>
                        <span style="display: block; font-family: var(--font); font-size: 10px; text-transform: uppercase; letter-spacing: 0.12em; color: var(--text-secondary); margin-bottom: 6px;">Email Address</span>
                        <span style="font-family: var(--font); font-size: 15px; font-weight: 600; color: var(--text);">{{ $user->email }}</span>
                    </div>

                    <div>
                        <span style="display: block; font-family: var(--font); font-size: 10px; text-transform: uppercase; letter-spacing: 0.12em; color: var(--text-secondary); margin-bottom: 6px;">Phone Number</span>
                        <span style="font-family: var(--font); font-size: 15px; font-weight: 600; color: var(--text);">{{ $user->phone ?? 'Not provided' }}</span>
                    </div>

                    <div>
                        <span style="display: block; font-family: var(--font); font-size: 10px; text-transform: uppercase; letter-spacing: 0.12em; color: var(--text-secondary); margin-bottom: 6px;">Date of Birth</span>
                        <span style="font-family: var(--font); font-size: 15px; font-weight: 600; color: var(--text);">{{ $user->dob ? \Carbon\Carbon::parse($user->dob)->format('d M Y') : 'Not provided' }}</span>
                    </div>

                    <div>
                        <span style="display: block; font-family: var(--font); font-size: 10px; text-transform: uppercase; letter-spacing: 0.12em; color: var(--text-secondary); margin-bottom: 6px;">Gender</span>
                        <span style="font-family: var(--font); font-size: 15px; font-weight: 600; color: var(--text); text-transform: capitalize;">{{ $user->gender ?? 'Not provided' }}</span>
                    </div>

                    <div style="grid-column: 1 / -1; padding-top: 24px; border-top: 1px solid var(--border);">
                        <span style="display: block; font-family: var(--font); font-size: 10px; text-transform: uppercase; letter-spacing: 0.12em; color: var(--text-secondary); margin-bottom: 6px;">Shipping Address</span>
                        <span style="font-family: var(--font); font-size: 15px; font-weight: 600; color: var(--text); line-height: 1.6;">{{ $user->address ?? 'Not provided' }}</span>
                    </div>
                </div>

                @if(!$user->phone || !$user->address)
                <div style="margin-top: 40px; background: #0d1a0d; padding: 20px 24px; border-left: 3px solid var(--primary);">
                    <h4 style="font-family: var(--font-heading); font-size: 15px; margin-bottom: 6px; color: var(--text);">MISSING INTEL</h4>
                    <p style="font-family: var(--font); font-size: 12px; color: var(--text-secondary); margin-bottom: 14px; line-height: 1.6;">Your personnel file is incomplete. Adding a phone number and shipping address ensures faster deployment during checkout.</p>
                    <a href="{{ route('profile.edit') }}" style="color: var(--primary); font-family: var(--font); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; text-decoration: none; border-bottom: 1px solid var(--primary); padding-bottom: 1px;">UPDATE CLEARANCE →</a>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

<style>
@media (max-width: 768px) {
    .profile-grid { grid-template-columns: 1fr !important; }
}
</style>

@endsection