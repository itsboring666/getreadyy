@extends('admin.layout')

@section('content')
<section class="mt-8" data-aos="fade-down">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📦 Order #{{ $order->order_id }}</h2>
        <a href="{{ route('admin.orders.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded shadow hover:bg-gray-300">
            &larr; Back to Orders
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Order Summary & Items -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Order Items</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        @php $product = $item->product; @endphp
                        <div class="flex gap-5 items-start border-b pb-5 last:border-0 last:pb-0">
                            {{-- Product Image --}}
                            @if($product && $product->image)
                            <a href="{{ $product ? route('products.show', $product->id) : '#' }}" target="_blank" class="flex-shrink-0">
                                <img src="{{ get_storage_url($product->image) }}"
                                     class="w-28 h-36 object-cover rounded-lg shadow border border-gray-100"
                                     alt="{{ $item->product_name }}">
                            </a>
                            @else
                            <div class="w-28 h-36 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 border">
                                <i class="fas fa-image text-gray-300 text-3xl"></i>
                            </div>
                            @endif

                            {{-- Product Details --}}
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-gray-900 text-base leading-tight mb-1">{{ $item->product_name }}</h4>
                                <div class="flex flex-wrap gap-3 mt-2">
                                    <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        <i class="fas fa-ruler text-gray-400"></i> Size: {{ $item->size }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        <i class="fas fa-hashtag text-blue-400"></i> Qty: {{ $item->quantity }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 mt-3">Unit Price: <span class="font-semibold text-gray-700">₹{{ number_format($item->price, 2) }}</span></p>
                                @if($product)
                                <p class="text-xs text-gray-400 mt-1">SKU / Product ID: {{ $product->id }}</p>
                                @endif
                            </div>

                            {{-- Line Total --}}
                            <div class="text-right flex-shrink-0">
                                <p class="text-lg font-bold text-gray-900">₹{{ number_format($item->price * $item->quantity, 2) }}</p>
                                @if($item->quantity > 1)
                                <p class="text-xs text-gray-400 mt-1">{{ $item->quantity }} × ₹{{ number_format($item->price, 2) }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>

            <div class="bg-white p-6 rounded-xl shadow" data-aos="fade-up" data-aos-delay="150">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Customer & Shipping Info</h3>
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                    <div>
                        <p class="font-semibold text-gray-900 text-base">{{ $order->name }}</p>
                        <p class="mt-1">
                            <a href="mailto:{{ $order->email }}" class="text-blue-600 hover:underline">{{ $order->email }}</a>
                        </p>
                        <p class="mt-1">
                            <a href="tel:{{ $order->phone }}" class="text-gray-700">{{ $order->phone }}</a>
                        </p>
                    </div>
                    <div>
                        <p>{{ $order->address }}</p>
                        <p>{{ $order->city }}, {{ $order->state }} — {{ $order->zip }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar: Status, Actions, Financials -->
        <div class="space-y-6">

            <!-- Status Update -->
            <div class="bg-white p-6 rounded-xl shadow" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Order Status</h3>
                
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Status</label>
                        <select name="status" class="w-full border-gray-300 rounded shadow-sm focus:ring-[#536451] focus:border-[#536451]">
                            <option value="pending"   {{ $order->status == 'pending'   ? 'selected' : '' }}>Pending</option>
                            <option value="paid"      {{ $order->status == 'paid'      ? 'selected' : '' }}>Paid</option>
                            <option value="shipped"   {{ $order->status == 'shipped'   ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Tracking Number / AWB</label>
                        <input type="text" name="tracking_number" value="{{ $order->tracking_number }}"
                            placeholder="e.g. BLUDART12345"
                            class="w-full border-gray-300 rounded shadow-sm focus:ring-[#536451] focus:border-[#536451]">
                    </div>

                    <button type="submit" class="w-full bg-[#536451] text-[#f3e9d5] py-2 rounded shadow hover:opacity-90 font-bold transition">
                        Update Order
                    </button>
                </form>

                @php
                    $whatsappPhone = $order->phone;
                    if (strlen($whatsappPhone) == 10) {
                        $whatsappPhone = '91' . $whatsappPhone;
                    }
                    $whatsappPhone = preg_replace('/[^0-9]/', '', $whatsappPhone);

                    $whatsappMessage = "Hi {$order->name},\n\nYour order *{$order->order_id}* was successful! 🎉\n\n";
                    $whatsappMessage .= "You can view your order details and download your official invoice here: " . route('orders.show', $order->order_id) . "\n\n";
                    $whatsappMessage .= "Thank you for shopping with GET READY! Stay stylish! 😎";
                    
                    $whatsappUrl = "https://wa.me/{$whatsappPhone}?text=" . urlencode($whatsappMessage);
                @endphp

                <div class="mt-3 pt-3 border-t border-gray-200">
                    <a href="{{ $whatsappUrl }}" target="_blank"
                        class="w-full flex items-center justify-center gap-2 bg-[#25D366] text-white py-2 rounded shadow hover:bg-[#20b858] font-bold transition">
                        <i class="fab fa-whatsapp text-lg"></i> Notify via WhatsApp
                    </a>
                </div>
            </div>

            <!-- Send Email -->
            <div class="bg-white p-6 rounded-xl shadow" data-aos="fade-up" data-aos-delay="220">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">📧 Email Customer</h3>
                <p class="text-sm text-gray-500 mb-4">
                    Send a confirmation email to <strong>{{ $order->email ?: 'N/A' }}</strong> with full order details.
                </p>
                @if($order->email)
                <form action="{{ route('admin.orders.sendConfirmation', $order->id) }}" method="POST"
                      onsubmit="return confirm('Send order confirmation email to {{ $order->email }}?')">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-blue-600 text-white py-2 rounded shadow hover:bg-blue-700 font-bold transition">
                        <i class="fas fa-envelope"></i> Send Confirmation Email
                    </button>
                </form>
                @else
                <div class="text-sm text-red-500 italic">No email address on file for this order.</div>
                @endif

                <div class="mt-3">
                    <a href="{{ route('admin.orders.invoice', $order->id) }}" target="_blank"
                        class="w-full flex items-center justify-center gap-2 bg-gray-800 text-white py-2 rounded shadow hover:bg-black font-bold transition">
                        <i class="fas fa-file-pdf"></i> Download Invoice PDF
                    </a>
                </div>
            </div>

            <!-- Financials -->
            <div class="bg-white p-6 rounded-xl shadow" data-aos="fade-up" data-aos-delay="250">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Financials</h3>
                @php
                    $shippingFee  = $order->shipping_fee ?? 0;
                    $discountAmt  = $order->discount_amount ?? 0;
                    $subtotalAmt  = $order->total_amount - $shippingFee + $discountAmt;
                @endphp
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal:</span>
                        <span>₹{{ number_format($subtotalAmt, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Shipping:</span>
                        <span>{{ $shippingFee > 0 ? '₹' . number_format($shippingFee, 2) : 'Free' }}</span>
                    </div>
                    @if($discountAmt > 0)
                    <div class="flex justify-between text-orange-600">
                        <span>Discount{{ $order->coupon_code ? ' (' . $order->coupon_code . ')' : '' }}:</span>
                        <span>— ₹{{ number_format($discountAmt, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between font-bold text-lg text-gray-800 border-t pt-2 mt-2">
                        <span>Total:</span>
                        <span>₹{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
