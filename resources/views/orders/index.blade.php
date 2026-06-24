@extends('layouts.front')
@section('title', 'Your Orders | GET READY')

@section('content')

<div class="gr-wardrobe" style="padding: 60px 24px 100px;">
    <div style="max-width: 1000px; margin: 0 auto;">
        
        <div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 16px;">
            <div>
                <h1 style="font-family: var(--font-heading); font-size: 36px; font-weight: 700; color: var(--text); margin-bottom: 8px;">DISPATCH LOG</h1>
                <p style="color: var(--text-secondary); font-family: var(--font); font-size: 14px; text-transform: uppercase; letter-spacing: 0.05em;">View and manage your past acquisitions.</p>
            </div>
            <a href="{{ route('products.all') }}" class="gr-hero-btn-primary" style="background: var(--text); font-size: 12px; padding: 12px 24px;">
                CONTINUE SHOPPING →
            </a>
        </div>

        @if ($orders->isEmpty())
        <div style="text-align: center; padding: 80px 20px; background: var(--surface); border: 1px solid var(--border);">
            <i class="fas fa-box-open" aria-hidden="true" style="font-size: 48px; color: var(--border); margin-bottom: 24px;"></i>
            <h3 style="font-family: var(--font-heading); font-size: 24px; margin-bottom: 12px; color: var(--text);">NO RECORD FOUND</h3>
            <p style="color: var(--text-secondary); font-family: var(--font); font-size: 14px; max-width: 400px; margin: 0 auto 24px;">You haven't placed any orders with us yet. When you do, they will be logged here.</p>
            <a href="{{ route('products.all') }}" class="gr-hero-btn-primary" style="display: inline-flex;">BEGIN DEPLOYMENT</a>
        </div>
        @else
        <div style="background: var(--surface); border: 1px solid var(--border); overflow: hidden;">
            <div style="overflow-x: auto;">
                <table style="width: 100%; text-align: left; border-collapse: collapse; min-width: 800px;">
                    <thead style="background: var(--bg); border-bottom: 1px solid var(--border);">
                        <tr>
                            <th style="padding: 16px 24px; font-family: var(--font); font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary);">Order ID</th>
                            <th style="padding: 16px 24px; font-family: var(--font); font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary);">Date</th>
                            <th style="padding: 16px 24px; font-family: var(--font); font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary);">Total</th>
                            <th style="padding: 16px 24px; font-family: var(--font); font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary);">Status</th>
                            <th style="padding: 16px 24px; font-family: var(--font); font-size: 11px; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-secondary); text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr style="border-bottom: 1px solid var(--border); transition: background 0.2s;" onmouseover="this.style.background='var(--bg-card)'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 24px; font-family: monospace; font-weight: 600; color: var(--text); font-size: 14px;">{{ $order->order_id }}</td>
                            <td style="padding: 24px; color: var(--text-secondary); font-size: 14px;">{{ $order->created_at->setTimezone('Asia/Kolkata')->format('d M Y') }}</td>
                            <td style="padding: 24px; font-weight: 600; font-size: 15px;">₹{{ number_format($order->total_amount, 2) }}</td>
                            <td style="padding: 24px;">
                                @switch($order->status)
                                    @case('paid')
                                        <span style="display: inline-block; padding: 4px 12px; border: 1px solid #28a745; font-size: 11px; font-weight: 700; color: #28a745; text-transform: uppercase; letter-spacing: 0.05em; border-radius: 2px;">Paid</span>
                                        @break
                                    @case('shipped')
                                        <span style="display: inline-block; padding: 4px 12px; border: 1px solid #17a2b8; font-size: 11px; font-weight: 700; color: #17a2b8; text-transform: uppercase; letter-spacing: 0.05em; border-radius: 2px;">Shipped</span>
                                        @break
                                    @case('delivered')
                                        <span style="display: inline-block; padding: 4px 12px; border: 1px solid #6610f2; font-size: 11px; font-weight: 700; color: #6610f2; text-transform: uppercase; letter-spacing: 0.05em; border-radius: 2px;">Delivered</span>
                                        @break
                                    @case('cancelled')
                                        <span style="display: inline-block; padding: 4px 12px; border: 1px solid #dc3545; font-size: 11px; font-weight: 700; color: #dc3545; text-transform: uppercase; letter-spacing: 0.05em; border-radius: 2px;">Cancelled</span>
                                        @break
                                    @case('pending')
                                        <span style="display: inline-block; padding: 4px 12px; border: 1px solid #ffc107; font-size: 11px; font-weight: 700; color: #ffc107; text-transform: uppercase; letter-spacing: 0.05em; border-radius: 2px;">Pending</span>
                                        @break
                                    @default
                                        <span style="display: inline-block; padding: 4px 12px; border: 1px solid var(--text-secondary); font-size: 11px; font-weight: 700; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em; border-radius: 2px;">{{ $order->status }}</span>
                                @endswitch
                            </td>
                            <td style="padding: 24px; text-align: right; display: flex; gap: 16px; justify-content: flex-end; align-items: center;">
                                <a href="{{ route('orders.show', $order->order_id) }}" style="color: var(--text); font-weight: 600; font-size: 13px; text-decoration: underline; text-underline-offset: 4px; text-transform: uppercase; letter-spacing: 0.05em;">View</a>
                                <a href="{{ route('orders.invoice', $order->order_id) }}" style="color: var(--accent); font-weight: 600; font-size: 13px; text-decoration: underline; text-underline-offset: 4px; text-transform: uppercase; letter-spacing: 0.05em;">Invoice</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection