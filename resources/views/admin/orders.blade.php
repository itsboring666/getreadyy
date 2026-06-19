@extends('admin.layout')

@section('content')
<section class="mt-8" data-aos="fade-down">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">📦 All Orders</h2>

    <div class="bg-white p-4 rounded-xl shadow overflow-x-auto" data-aos="fade-up" data-aos-delay="100">
        <table class="w-full table-auto text-sm">
            <thead>
                <tr class="bg-[#536451] text-[#f3e9d5] uppercase text-xs">
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Order ID</th>
                    <th class="px-4 py-3 text-left">User</th>
                    <th class="px-4 py-3 text-left">Total (₹)</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @forelse ($orders as $order)
                <tr class="border-t hover:bg-gray-50 transition" data-aos="fade-up" data-aos-delay="{{ ($loop->index + 1) * 50 }}">
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-mono">{{ $order->order_id }}</td>
                    <td class="px-4 py-3">{{ $order->user->name ?? 'Guest' }}</td>
                    <td class="px-4 py-3">₹{{ number_format($order->total_amount, 2) }}</td>
                    <td class="px-4 py-3 capitalize">
                        @switch($order->status)
                            @case('pending')
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                @break
                            @case('paid')
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Paid</span>
                                @break
                            @case('shipped')
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Shipped</span>
                                @break
                            @case('delivered')
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">Delivered</span>
                                @break
                            @case('cancelled')
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-600">Cancelled</span>
                                @break
                            @default
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 capitalize">{{ $order->status }}</span>
                        @endswitch
                    </td>
                    <td class="px-4 py-3">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('admin.orders.show', ['orderId' => $order->order_id]) }}"
                           class="bg-[#536451] text-white px-3 py-1 rounded text-xs hover:bg-opacity-90 font-medium">
                            View Order
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-gray-500 py-6">No orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</section>
@endsection
