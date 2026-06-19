@extends('admin.layout')

@section('content')
    <h1 class="text-3xl font-bold mb-8">Welcome Admin 👋</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <a href="{{ route('admin.orders.index') }}" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition block">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Orders</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</h2>
            <p class="text-sm text-gray-500 mt-1">Total Orders</p>
        </a>

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-rupee-sign text-green-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">Revenue</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-800">₹{{ number_format($totalRevenue, 0) }}</h2>
            <p class="text-sm text-gray-500 mt-1">Total Revenue (Paid)</p>
        </div>

        <a href="{{ route('admin.products.index') }}" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition block">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-tshirt text-purple-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-purple-600 bg-purple-50 px-2 py-1 rounded-full">Products</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-800">{{ $totalProducts }}</h2>
            <p class="text-sm text-gray-500 mt-1">Active Products</p>
        </a>

        <a href="{{ route('admin.emails.index') }}" class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition block">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-envelope text-amber-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2 py-1 rounded-full">Emails</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-800">{{ $totalSubscribers }}</h2>
            <p class="text-sm text-gray-500 mt-1">Newsletter Subscribers</p>
        </a>
    </div>

    @if($pendingOrders > 0)
    <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-6 py-4 rounded-xl mb-8 flex items-center gap-4">
        <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
        <div>
            <strong>{{ $pendingOrders }} pending order{{ $pendingOrders > 1 ? 's' : '' }}</strong> require attention.
            <a href="{{ route('admin.orders.index') }}" class="underline font-semibold ml-1">View Orders →</a>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Recent Orders --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-gray-800">Recent Orders</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-[#536451] font-semibold hover:underline">View All →</a>
            </div>
            @if($recentOrders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-sm">
                    <thead>
                        <tr class="text-xs text-gray-500 uppercase border-b">
                            <th class="px-3 py-3 text-left">Order ID</th>
                            <th class="px-3 py-3 text-left">Customer</th>
                            <th class="px-3 py-3 text-left">Total</th>
                            <th class="px-3 py-3 text-left">Status</th>
                            <th class="px-3 py-3 text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-3 py-3 font-mono text-sm">
                                <a href="{{ route('admin.orders.show', ['orderId' => $order->order_id]) }}" class="text-[#536451] font-semibold hover:underline">{{ $order->order_id }}</a>
                            </td>
                            <td class="px-3 py-3">{{ $order->user->name ?? $order->name }}</td>
                            <td class="px-3 py-3 font-medium">₹{{ number_format($order->total_amount, 0) }}</td>
                            <td class="px-3 py-3">
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
                            <td class="px-3 py-3 text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-center text-gray-400 py-8">No orders yet.</p>
            @endif
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-bold text-gray-800 mb-6">Quick Actions</h2>
            <div class="space-y-3">
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition text-gray-700 font-medium">
                    <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center"><i class="fas fa-plus text-purple-500"></i></div>
                    Manage Products
                </a>
                <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition text-gray-700 font-medium">
                    <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center"><i class="fas fa-tags text-indigo-500"></i></div>
                    Manage Categories
                </a>
                <a href="{{ route('admin.carousels.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition text-gray-700 font-medium">
                    <div class="w-10 h-10 bg-pink-50 rounded-lg flex items-center justify-center"><i class="fas fa-images text-pink-500"></i></div>
                    Manage Carousel
                </a>
                <a href="{{ route('admin.featured.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition text-gray-700 font-medium">
                    <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center"><i class="fas fa-star text-amber-500"></i></div>
                    Featured Product
                </a>
                <a href="{{ route('admin.new-arrivals.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition text-gray-700 font-medium">
                    <div class="w-10 h-10 bg-teal-50 rounded-lg flex items-center justify-center"><i class="fas fa-bolt text-teal-500"></i></div>
                    New Arrivals
                </a>
                <a href="{{ route('admin.emails.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition text-gray-700 font-medium">
                    <div class="w-10 h-10 bg-rose-50 rounded-lg flex items-center justify-center"><i class="fas fa-envelope text-rose-500"></i></div>
                    Email Subscribers
                </a>
            </div>
        </div>
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
        {{-- Daily Sales Chart --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-bold text-gray-800 mb-6">Daily Sales Trend (Last 30 Days)</h2>
            <div style="height: 300px; position: relative;">
                <canvas id="salesTrendChart"></canvas>
            </div>
        </div>

        {{-- Category Popularity Chart --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-bold text-gray-800 mb-6">Popular Categories (Units Sold)</h2>
            <div style="height: 300px; position: relative;">
                <canvas id="categoryPopularityChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Chart rendering script --}}
    <script>
        (function() {
            // Sales Trend
            const salesData = @json($salesData);
            const salesLabels = salesData.map(item => item.date);
            const salesValues = salesData.map(item => item.total);

            const salesCtx = document.getElementById('salesTrendChart').getContext('2d');
            if (salesCtx) {
                new Chart(salesCtx, {
                    type: 'line',
                    data: {
                        labels: salesLabels,
                        datasets: [{
                            label: 'Sales (₹)',
                            data: salesValues,
                            borderColor: '#536451',
                            backgroundColor: 'rgba(83, 100, 81, 0.1)',
                            borderWidth: 3,
                            tension: 0.3,
                            fill: true,
                            pointBackgroundColor: '#bebc65',
                            pointBorderColor: '#536451',
                            pointRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0, 0, 0, 0.05)' }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            }

            // Category Popularity
            const categoryData = @json($categoryPopularity);
            const catLabels = categoryData.map(item => item.category_name);
            const catValues = categoryData.map(item => item.total_qty);

            const catCtx = document.getElementById('categoryPopularityChart').getContext('2d');
            if (catCtx) {
                new Chart(catCtx, {
                    type: 'bar',
                    data: {
                        labels: catLabels,
                        datasets: [{
                            label: 'Units Sold',
                            data: catValues,
                            backgroundColor: '#bebc65',
                            borderColor: '#536451',
                            borderWidth: 2,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0, 0, 0, 0.05)' }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            }
        })();
    </script>
@endsection
