<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto grid grid-cols-12 gap-4 mt-4">
        <div class="col-span-8">
            <form class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-1" action="{{ route('order.update', $order->id) }}" method="post">
                @csrf
                @method('PUT')
                <div>
                    <x-input-label for="delivery_date" :value="__('Delivery date')" />
                    <x-text-input id="delivery_date" class="block mt-1 w-full" type="date" name="delivery_date" :value="$order->delivery_date" required autofocus autocomplete="delivery_date" />
                    <x-input-error :messages="$errors->get('delivery_date')" class="mt-2" />
                </div>
                <br>
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$order->email" required autofocus autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <br>
                <div>
                    <x-input-label for="phone" :value="__('Phone')" />
                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="$order->phone" required autofocus autocomplete="phone" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>
                <br>
                <div>
                    <x-input-label for="address" :value="__('Address')" />
                    <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="$order->address" required autofocus autocomplete="address" />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                <h2>Total: {{ $total }} р.</h2>

                <x-primary-button type="submit" class="order mt-1">
                    {{ __('Update order') }}
                </x-primary-button>
            </form>
            <form action="{{ route('order.destroy', $order->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">
                    Delete
                </button>
            </form>
        </div>
        <div class="col-span-4">
            <div id="myMap" style="height: 100%;"></div>
        </div>
        <div class="col-span-12">
            @foreach($order->products as $product)
                <div class="block mb-4 p-1 rounded">
                    <p>Title: {{ $product->title }} - Amount: {{ $product->pivot->amount }} - Price: {{ $product->price }} р</p>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        $(document).ready(() => {
            let myMap;

            ymaps.ready(() => {
                myMap = new ymaps.Map ('myMap', {
                    center: [55.75, 37.61],
                    zoom: 3,
                    type: 'yandex#satellite'
                });

                myMap.controls
                    .add('mapTools')
                    .add('typeSelector')
                    .add('zoomControl')
            });

            $('#address').keyup(function() {
                delay(() => {
                    ymaps.geocode($(this).val(), { //ищем по нужному адресу
                        results: 1
                    }).then(function(res) {
                        myMap.geoObjects.add(res.geoObjects.get(0));
                    });
                }, 1000)
            })

            setTimeout(() => {
                ymaps.geocode('{{ $order->address }}', { //ищем по нужному адресу
                    results: 1
                }).then(function(res) {
                    myMap.geoObjects.add(res.geoObjects.get(0));
                });
            }, 1000)
        })


        let delay = (function(){
            let timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();
    </script>
</x-app-layout>
