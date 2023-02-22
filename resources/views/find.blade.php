<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://api-maps.yandex.ru/2.0-stable/?apikey=80292fc3-2eeb-4eea-a092-6d30d089a95b&load=package.full&lang=ru-RU" type="text/javascript"></script>
        <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
        <title>Document</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-100">
        <nav x-data="{ open: false }" class="bg-white border-b border-gray-100 ">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}">
                                <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link :href="route('index')" :active="request()->routeIs('dashboard')">
                                {{ __('LaraStore') }}
                            </x-nav-link>
                        </div>

                    </div>

                    <form class="flex gap-1" method="get" action="{{ route('find') }}">
                        @csrf
                        <x-text-input id="secret" class="block my-1 w-full" type="text" name="secret" :value="old('secret')" placeholder="Find my order by secret" required autofocus autocomplete="secret" />
                        <x-input-error :messages="$errors->get('secret')" class="mt-2" />
                        <button onclick="" class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-1">Find</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="py-12">
            <div class="max-w-7xl mx-auto grid grid-cols-12 gap-4">
                <div class="col-span-8 sm:px-6 lg:px-8">
                    <h1 class="font-bold">Order</h1>
                    <p>Delivery date: {{ $order->delivery_date }}</p>
                    <p>Email: {{ $order->email }}</p>
                    <p>Phone: {{ $order->phone ?? 'Not specified' }}</p>
                    <p>Address: {{ $order->address ?? 'Not specified' }}</p>
                    <p>Total: {{ $total }} р.</p>
                    <input type="hidden" value="{{ $order->address }}">
                    <h2 class="font-bold">Positions</h2>
                    @foreach($order->products as $product)
                        <div class="block mb-4 p-1 rounded">
                            <p>Title: {{ $product->title }} - Amount: {{ $product->pivot->amount }} - Price: {{ $product->price }} р</p>
                        </div>
                    @endforeach
                </div>
                <div class="col-span-4 sm:pr-6 lg:pr-8" id="myMap">
                </div>
            </div>
        </div>
    </body>
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
</html>
