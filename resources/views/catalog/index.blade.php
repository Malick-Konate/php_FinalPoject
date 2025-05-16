<x-guest-layout> {{-- Or a different layout if you have one for the public site --}}
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-6">Our Products</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if ($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            No Image
                        </div>
                    @endif
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-1">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ $product->category }}</p>
                        <p class="text-gray-800 font-bold mb-3">${{ number_format($product->price, 2) }}</p>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-guest-layout>