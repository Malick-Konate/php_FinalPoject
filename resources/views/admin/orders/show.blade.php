<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Details (Admin)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                     <div class="flex justify-between items-center mb-6">
                         <h3 class="text-lg font-medium text-gray-900">Order #{{ $order->id }} Details</h3>
                         <a href="{{ route('admin.orders.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm">
                             Back to Orders List
                         </a>
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Customer Information --}}
                        <div>
                            <h4 class="text-xl font-semibold mb-3">Customer Information</h4>
                            <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                            <p><strong>Address:</strong> {{ $order->customer_address }}</p>
                            @if ($order->user)
                                <p class="text-sm text-gray-600 mt-2">(Linked to registered user: {{ $order->user->email }})</p>
                            @else
                                <p class="text-sm text-gray-600 mt-2">(Guest Checkout)</p>
                            @endif
                        </div>

                        {{-- Order Summary --}}
                        <div>
                            <h4 class="text-xl font-semibold mb-3">Order Summary</h4>
                            <p><strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                            <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                            <p class="text-2xl font-bold text-green-700 mt-4">Total Amount: ${{ number_format($order->total_amount, 2) }}</p>
                        </div>
                    </div>

                    {{-- Ordered Items --}}
                    <div class="mt-8">
                        <h4 class="text-xl font-semibold mb-3">Items Ordered</h4>
                         <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Product
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Price
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Quantity
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Subtotal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($order->items as $item)
                                        <tr>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $item->product_name }}
                                             </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                ${{ number_format($item->price, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                ${{ number_format($item->price * $item->quantity, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>