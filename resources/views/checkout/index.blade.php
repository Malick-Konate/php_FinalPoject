<x-guest-layout> {{-- Or your public layout --}}
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Checkout</h2>

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @if ($cart && count($cart) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Order Summary --}}
                <div>
                    <h3 class="text-xl font-semibold mb-4">Order Summary</h3>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <ul>
                            @foreach ($cart as $item)
                                <li class="flex justify-between py-2 border-b">
                                    <span class="text-gray-700">{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                                    <span class="text-gray-700">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="flex justify-between mt-4 font-bold text-lg">
                            <span>Total:</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Checkout Form --}}
                <div>
                    <h3 class="text-xl font-semibold mb-4">Shipping and Payment Details</h3>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <form action="{{ route('checkout.placeOrder') }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label for="customer_name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="customer_name" id="customer_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('customer_name', Auth::user()->name ?? '') }}" required>
                                @error('customer_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="customer_email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="customer_email" id="customer_email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('customer_email', Auth::user()->email ?? '') }}" required>
                                 @error('customer_email')
                                    <p class="text-red-500 text-xs mt-1"></p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="customer_address" class="block text-sm font-medium text-gray-700">Address</label>
                                <textarea name="customer_address" id="customer_address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('customer_address') }}</textarea>
                                 @error('customer_address')
                                    <p class="text-red-500 text-xs mt-1"></p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                                <input type="text" name="payment_method" id="payment_method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('payment_method') }}" placeholder="e.g., Credit Card, PayPal, Cash on Delivery" required>
                                @error('payment_method')
                                    <p class="text-red-500 text-xs mt-1"></p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Place Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
             <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
                Your cart is empty.
                <div class="mt-4">
                     <a href="{{ route('catalog.index') }}" class="text-blue-500 hover:underline">Start Shopping</a>
                </div>
            </div>
        @endif
    </div>
</x-guest-layout>