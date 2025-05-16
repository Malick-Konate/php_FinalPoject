<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                         <h3 class="text-lg font-medium text-gray-900">{{ $product->name }}</h3>
                         <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm">
                             Back to Products
                         </a>
                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            @if ($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover rounded-md shadow-md">
                            @else
                                <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded-md shadow-md">
                                    <span class="text-gray-500 text-xl">No Image Available</span>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="text-gray-700 mb-2"><strong class="font-medium">Category:</strong> {{ $product->category }}</p>
                            <p class="text-gray-700 mb-2"><strong class="font-medium">Price:</strong> ${{ number_format($product->price, 2) }}</p>
                            <p class="text-gray-700 mb-4"><strong class="font-medium">Stock Quantity:</strong> {{ $product->stock_quantity }}</p>
                            <p class="text-gray-700"><strong class="font-medium">Description:</strong></p>
                            <p class="text-gray-600 mt-2">{{ $product->description }}</p>

                             <div class="mt-6 flex space-x-3">
                                 <a href="{{ route('products.edit', $product->id) }}" class="bg-indigo-600 hover:bg-indigo-900 text-white font-bold py-2 px-4 rounded text-sm">Edit Product</a>
                                 <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                     @csrf
                                     @method('DELETE')
                                     <button type="submit" class="bg-red-600 hover:bg-red-900 text-white font-bold py-2 px-4 rounded text-sm" onclick="return confirm('Are you sure you want to delete this product?')">Delete Product</button>
                                 </form>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>