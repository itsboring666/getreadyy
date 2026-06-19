@extends('admin.layout')

@section('content')
<section class="mt-8" data-aos="fade-down">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">⚠️ Cancel & Return Requests</h2>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-medium rounded-r shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 font-medium rounded-r shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-xl shadow overflow-x-auto" data-aos="fade-up" data-aos-delay="100">
        <table class="w-full table-auto text-sm">
            <thead>
                <tr class="bg-[#536451] text-[#f3e9d5] uppercase text-xs">
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Order ID</th>
                    <th class="px-4 py-3 text-left">User</th>
                    <th class="px-4 py-3 text-left">Request Type</th>
                    <th class="px-4 py-3 text-left">Total (₹)</th>
                    <th class="px-4 py-3 text-left">Date Requested</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @forelse ($orders as $order)
                <tr class="border-t hover:bg-gray-50 transition" data-aos="fade-up" data-aos-delay="{{ ($loop->index + 1) * 50 }}">
                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-mono text-xs font-semibold text-gray-600">{{ $order->order_id }}</td>
                    <td class="px-4 py-3">
                        <div class="font-medium text-gray-900">{{ $order->user->name ?? 'Guest' }}</div>
                        <div class="text-xs text-gray-500">{{ $order->user->email ?? '' }}</div>
                    </td>
                    <td class="px-4 py-3">
                        @if ($order->status === 'cancel_requested')
                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                🛑 Cancel Requested
                            </span>
                        @elseif ($order->status === 'return_requested')
                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                🔄 Return Requested
                            </span>
                        @else
                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 capitalize">
                                {{ $order->status }}
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 font-medium">₹{{ number_format($order->total_amount, 2) }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $order->updated_at->format('d M Y, h:i A') }}</td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.orders.show', ['orderId' => $order->order_id]) }}"
                               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded text-xs font-medium transition duration-200">
                                Details
                            </a>
                            <form action="{{ route('admin.orders.requests.approve', ['id' => $order->id]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to APPROVE this request?')">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs font-medium transition duration-200">
                                    Approve
                                </button>
                            </form>
                            <form action="{{ route('admin.orders.requests.reject', ['id' => $order->id]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to REJECT this request?')">
                                @csrf
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-xs font-medium transition duration-200">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-gray-500 py-8 italic">No pending cancel or return requests found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
