<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>
    <br>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <form action="{{ route('product.update', $product->id) }}" method="post">
            @method('PATCH')
            @csrf
            <div>
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ $product->title }}" required autofocus autocomplete="title" />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>
            <br>
            <div>
                <x-input-label for="price" :value="__('Price')" />
                <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" value="{{ $product->price }}" required autocomplete="price" />
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
            </div>
            <br>
            <x-primary-button class="">
                {{ __('Update product') }}
            </x-primary-button>
        </form>
        <form action="{{ route('product.destroy', $product->id) }}" method="post">
            @csrf
            @method('DELETE')
            <x-danger-button class="mt-3">
                {{ __('x') }}
            </x-danger-button>
        </form>
    </div>
</x-app-layout>
