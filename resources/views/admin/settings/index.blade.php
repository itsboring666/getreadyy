@extends('admin.layout')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md mt-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Store Settings</h1>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        
        <div class="mb-6 border border-gray-200 rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4 border-b pb-2">Shipping Configuration</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="shipping_fee" class="block text-sm font-medium text-gray-700 mb-2">Standard Shipping Fee (₹)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">₹</span>
                        </div>
                        <input type="number" name="shipping_fee" id="shipping_fee" step="0.01" value="{{ old('shipping_fee', $shipping_fee) }}" class="pl-8 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2" required>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">The default cost of shipping applied to orders.</p>
                </div>

                <div>
                    <label for="free_shipping_threshold" class="block text-sm font-medium text-gray-700 mb-2">Free Shipping Minimum (₹)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">₹</span>
                        </div>
                        <input type="number" name="free_shipping_threshold" id="free_shipping_threshold" step="0.01" value="{{ old('free_shipping_threshold', $free_shipping_threshold) }}" class="pl-8 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border p-2" required>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Orders equal to or above this amount will get free shipping.</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-[#536451] hover:bg-[#3f4d3d] text-white font-bold py-2 px-6 rounded-lg shadow transition">
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection
