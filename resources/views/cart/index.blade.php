<x-guest-layout> {{-- Or your public layout --}}
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Shopping Cart</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

         @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif


        @if (session('cart') && count(session('cart')) > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
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
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Remove</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php $total = 0 @endphp
                        @foreach (session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if ($details['image_path'])
                                                 <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $details['image_path']) }}" alt="{{ $details['name'] }}">
                                            @else
                                                 <span class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-xs">No Img</span>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $details['name'] }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($details['price'], 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="form-input w-16 rounded-md border-gray-300 shadow-sm mr-2 text-sm">
                                        <button type="submit" class="text-indigo-600 hover:text-indigo-900 text-sm">Update</button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($details['price'] * $details['quantity'], 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                     <form action="{{ route('cart.remove', $id) }}" method="POST">
                                         @csrf
                                         @method('DELETE')
                                         <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Remove</button>
                                     </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6 text-right">
                    <h4 class="text-xl font-bold">Total: ${{ number_format($total, 2) }}</h4>
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('catalog.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-4">Continue Shopping</a>
                    <a href="#" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Proceed to Checkout</a> {{-- Link to your checkout page --}}
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