<div class="">
    <div class="grid grid-cols-12 gap-4">
        @foreach($products as $product)
            <div class="col-span-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2>{{ $product->title }}</h2>
                        <p>{{ $product->price }} р.</p>
                        <button onclick="addToCart({{ $product->id }}, '{{ $product->title }}', {{ $product->price }})" class="bg-green-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">+</button>
                        <button onclick="removeFromCart({{ $product->id }})" class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">-</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4"></div>
    {!! $products->links() !!}

</div>
