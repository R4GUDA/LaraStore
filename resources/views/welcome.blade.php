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
                    @livewire('products')
                </div>
                <div class="col-span-4 sm:pr-6 lg:pr-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        @if($errors->any())
                            <h4>{{$errors->first('error')}}</h4>
                        @endif
                        <form class="p-6 text-gray-900" id="order-form">
                            <div>
                                <x-input-label for="delivery_date" :value="__('Delivery date')" />
                                <x-text-input id="delivery_date" class="block mt-1 w-full" type="date" name="delivery_date" :value="old('delivery_date')" required autofocus autocomplete="delivery_date" />
                                <x-input-error :messages="$errors->get('delivery_date')" class="mt-2" />
                            </div>
                            <br>
                            <div>
                                <x-input-label for="phone" :value="__('Phone')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="date" :value="old('phone')" required autofocus autocomplete="phone" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                            <br>
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" autofocus autocomplete="email" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <br>
                            <div class="">
                                <div class="mb-1">
                                    <x-input-label for="address" :value="__('Address')" />
                                    <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" autofocus autocomplete="address" />
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>
                                <div id="myMap" style="width: 100%; height: 300px;"></div>
                            </div>
                            <button></button>
                            <br>
                            <div>
                                <h2 class="font-medium text-sm text-gray-700 mb-1">Order positions</h2>
                                <div class="positions">
                                </div>
                            </div>

                            <x-primary-button type="button" class="order">
                                {{ __('Order') }}
                            </x-primary-button>
                            Total: <span class="total">0</span>
                            <p>
                                Min:3000
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @livewireScripts
    </body>
    <script>
        ymaps.ready(init);
        let myMap;
        function init() {
            myMap = new ymaps.Map ('myMap', {
                center: [55.75, 37.61],
                zoom: 3,
                type: 'yandex#satellite'
            });

            myMap.controls
                .add('mapTools')
                .add('typeSelector')
                .add('zoomControl')
        }

        $(document).ready(function() {
            $('#address').keyup(function() {
                delay(() => {
                    ymaps.geocode($(this).val(), { //ищем по нужному адресу
                        boundedBy: myMap.getBounds(),
                        results: 1
                    }).then(function(res) {
                        myMap.geoObjects.add(res.geoObjects.get(0));
                    });
                }, 1000)
            })
        })

        let delay = (function(){
            let timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();

        let cart = []

        function addToCart(product_id, title, price) {
            let indexOfEl = cart.findIndex(n => n.product_id === product_id)
            if (indexOfEl === -1) {
                cart.push({
                    'product_id': product_id,
                    'amount': 1,
                    'title': title,
                    'price': price
                })
            }
            else {
                cart[indexOfEl].amount++
            }

            updateUICart()
        }

        function removeFromCart(product_id) {
            let indexToRemove = cart.findIndex(n => n.product_id === product_id)

            cart[indexToRemove].amount--

            if(cart[indexToRemove].amount === 0) {
                cart.splice(indexToRemove, 1);
            }

            updateUICart()
        }

        let total = 0

        function updateUICart() {
            total = 0
            $('.positions').empty()

            cart.forEach((el) => {
                $('.positions').append(`
                    <div class="block mb-4 shadow p-1 rounded">
                        <p>Title: `+ el.title +` - Amount: `+ el.amount +` - Price: `+ el.price +` р</p>
                        <button onclick="addToCart(`+ el.product_id +`,`+ el.title +`,`+ el.price +`" class="bg-green-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">+</button>
                        <button onclick="removeFromCart(`+ el.product_id +`)" class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">-</button>
                    </div>
                `)

                total += el.price * el.amount
            })

            $('.total').text(total)
        }

        $('.order').click((e) => {
            e.preventDefault(e)

            if (!cart) {
                alert('cart is empty')
                return
            }

            if (total < 3000) {
                alert('Order for more than 3000 rubles')
                return
            }

            cart.forEach((el) => {
                delete el['price']
                delete el['title']
            })

            $.ajax({
                method: 'post',
                url: '/api/order',
                dataType : "json",
                data: {
                    'delivery_date': $('#delivery_date').val(),
                    'email': $('#email').val(),
                    'phone': $('#phone').val(),
                    'address': $('#address').val(),
                    'positions': cart
                },
                success: function (res) {
                    alert('Order created. Your personal token:' + res.data.secret)
                },
                error: function (err,) {
                    alert(err.responseJSON.message)
                }
            })
        })
    </script>
</html>
