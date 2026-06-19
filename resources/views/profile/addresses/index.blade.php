@extends('layouts.front')
@section('title', 'Address Book | GET READY')

@section('content')

<div class="gr-wardrobe" style="padding: 60px 24px 100px;">
    <div style="max-width: 1000px; margin: 0 auto;">

        <div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px;">
            <div>
                <h1 style="font-family: var(--font-heading); font-size: 36px; font-weight: 700; color: var(--text); margin-bottom: 8px;">ADDRESS BOOK</h1>
                <p style="color: var(--text-secondary); font-family: var(--font); font-size: 14px; text-transform: uppercase; letter-spacing: 0.05em;">Manage your delivery coordinates.</p>
            </div>
            <a href="{{ route('addresses.create') }}" class="gr-hero-btn-primary" style="font-size: 11px; padding: 12px 24px;">
                <i class="fas fa-plus" style="margin-right: 8px;"></i> ADD NEW ADDRESS
            </a>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 3fr; gap: 32px;" class="profile-grid">

            {{-- Sidebar --}}
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="background: #161616; border: 1px solid var(--border); padding: 28px; text-align: center;">
                    <div style="width: 72px; height: 72px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: var(--font-heading); font-size: 30px; margin: 0 auto 14px;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <h3 style="font-family: var(--font-heading); font-size: 18px; margin-bottom: 4px; color: var(--text);">{{ auth()->user()->name }}</h3>
                    <p style="font-family: var(--font); font-size: 11px; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.08em;">{{ auth()->user()->email }}</p>
                </div>

                <a href="{{ route('profile.show') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; background: #161616; border: 1px solid var(--border); color: var(--text); text-decoration: none; font-family: var(--font); font-weight: 600; font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em; transition: border-color 0.2s, background 0.2s;" onmouseover="this.style.background='#1e1e1e'; this.style.borderColor='var(--primary)';" onmouseout="this.style.background='#161616'; this.style.borderColor='var(--border)';">
                    <span><i class="fas fa-user" style="margin-right: 8px;"></i> Personnel File</span>
                    <i class="fas fa-chevron-right" style="color: var(--text-secondary);"></i>
                </a>

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

                {{-- Active: Address Book --}}
                <a href="{{ route('addresses.index') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 14px 16px; background: rgba(153,27,27,0.12); border: 1px solid var(--primary); color: var(--primary); text-decoration: none; font-family: var(--font); font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.08em;">
                    <span><i class="fas fa-address-book" style="margin-right: 8px;"></i> Address Book</span>
                    <i class="fas fa-chevron-right"></i>
                </a>

                <form method="POST" action="{{ route('logout') }}" style="margin-top: 8px;">
                    @csrf
                    <button type="submit" style="width: 100%; display: flex; align-items: center; justify-content: center; padding: 14px; background: transparent; border: 1px solid var(--primary); color: var(--primary); font-family: var(--font); font-weight: 700; font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='var(--primary)'; this.style.color='#fff';" onmouseout="this.style.background='transparent'; this.style.color='var(--primary)';">
                        <i class="fas fa-sign-out-alt" style="margin-right: 8px;"></i> TERMINATE SESSION
                    </button>
                </form>
            </div>

            {{-- Address Cards --}}
            <div>
                @if($addresses->count() > 0)
                    <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
                        @foreach($addresses as $addr)
                        <div style="background: #161616; border: 1px solid {{ $addr->is_default ? 'var(--primary)' : 'var(--border)' }}; box-shadow: {{ $addr->is_default ? '4px 4px 0px rgba(153,27,27,0.4)' : '4px 4px 0px rgba(0,0,0,0.4)' }}; padding: 28px; position: relative;">

                            {{-- Card header --}}
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; padding-bottom: 14px; border-bottom: 1px dashed var(--border);">
                                <span style="font-family: var(--font-heading); font-size: 17px; font-weight: 700; background: var(--primary); color: #fff; padding: 4px 14px; text-transform: uppercase; letter-spacing: 0.06em;">
                                    {{ $addr->address_name }}
                                </span>
                                @if($addr->is_default)
                                    <span style="font-family: var(--font); font-size: 10px; font-weight: 700; color: var(--primary); border: 1px solid var(--primary); padding: 4px 10px; text-transform: uppercase; letter-spacing: 0.1em; background: rgba(153,27,27,0.1);">
                                        ✓ DEFAULT
                                    </span>
                                @endif
                            </div>

                            {{-- Address info --}}
                            <div style="font-family: var(--font); font-size: 13px; color: var(--text); line-height: 1.8; margin-bottom: 20px;">
                                <strong style="font-size: 15px; text-transform: uppercase; letter-spacing: 0.06em; display: block; margin-bottom: 6px; color: var(--text);">{{ $addr->name }}</strong>
                                <span style="display: block; font-family: var(--font-serif); font-style: italic; color: var(--text-secondary);">{{ $addr->address }}</span>
                                <span style="display: block; color: var(--text-secondary);">{{ $addr->city }}, {{ $addr->state }} — {{ $addr->zip }}</span>
                                <span style="display: block; margin-top: 6px; color: var(--text-muted); font-size: 11px; font-family: monospace; letter-spacing: 0.05em;">☎ {{ $addr->phone }}</span>
                            </div>

                            {{-- Actions --}}
                            <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap; border-top: 1px solid var(--border); padding-top: 16px;">
                                <a href="{{ route('addresses.edit', $addr->id) }}" class="gr-hero-btn-primary" style="font-size: 10px; padding: 8px 18px;">
                                    <i class="fas fa-edit" style="margin-right: 6px;"></i> EDIT
                                </a>

                                <form action="{{ route('addresses.destroy', $addr->id) }}" method="POST" onsubmit="return confirm('Delete this address?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: transparent; border: 1px solid var(--primary); color: var(--primary); padding: 8px 18px; font-weight: 700; font-size: 10px; font-family: var(--font); text-transform: uppercase; letter-spacing: 0.08em; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='var(--primary)'; this.style.color='#fff';" onmouseout="this.style.background='transparent'; this.style.color='var(--primary)';">
                                        <i class="fas fa-trash-alt" style="margin-right: 6px;"></i> DELETE
                                    </button>
                                </form>

                                @if(!$addr->is_default)
                                    <form action="{{ route('addresses.default', $addr->id) }}" method="POST" style="display:inline; margin-left: auto;">
                                        @csrf
                                        <button type="submit" style="background: #1a1a1a; border: 1px solid var(--border); color: var(--text-secondary); padding: 8px 18px; font-weight: 700; font-size: 10px; font-family: var(--font); text-transform: uppercase; letter-spacing: 0.08em; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--primary)'; this.style.color='var(--text)';" onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--text-secondary)';">
                                            SET AS DEFAULT
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>

                @else
                    <div style="background: #161616; border: 1px solid var(--border); padding: 60px; text-align: center;">
                        <i class="fas fa-address-card" style="font-size: 48px; color: var(--border); margin-bottom: 16px; display: block;"></i>
                        <h3 style="font-family: var(--font-heading); font-size: 22px; margin-bottom: 8px; color: var(--text);">NO SAVED COORDINATES</h3>
                        <p style="font-family: var(--font); font-size: 13px; color: var(--text-secondary); margin-bottom: 24px; line-height: 1.6;">Your address book is empty.<br>Add a delivery destination for faster checkout.</p>
                        <a href="{{ route('addresses.create') }}" class="gr-hero-btn-primary" style="font-size: 11px;">
                            <i class="fas fa-plus" style="margin-right: 8px;"></i> ADD NEW ADDRESS
                        </a>
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
