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
    <div class="p-2">
        <div class="max-w-7xl mx-auto gap-4">
            <table class="table table-bordered w-full">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Delivery date</th>
                    <th>email</th>
                    <th>secret</th>
                    <th>phone</th>
                    <th>address</th>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td class="py-1">{{$order->id}}</td>
                        <td class="py-1">{{$order->delivery_date}}</td>
                        <td class="py-1">{{$order->email}}</td>
                        <td class="py-1">{{$order->secret}}</td>
                        <td class="py-1">{{$order->phone}}</td>
                        <td class="py-1">{{$order->address}}</td>
                        <td class="py-1"><a class="bg-green-300 p-1 rounded" href="{{ route('order.show', $order->id) }}">Open</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <br>
            {!! $orders->links() !!}
        </div>
    </div>
    <br>
    <br>
    <h1>// Не разобрался как пользоваться DataTable, все что смог ниже (Не очень документации под 10 Лару)</h1>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="p-2">
        <table class="table table-bordered yajra-datatable">
            <thead>
            <tr>
                <th>Id</th>
                <th>delivery_date</th>
                <th>email</th>
                <th>phone</th>
                <th>address</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <script type="text/javascript">
        $(function () {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('getOrders') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'delivery_date', name: 'delivery_date'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'address', name: 'address'},
                    {
                        data: 'id',
                        name: '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>',
                        orderable: true,
                        searchable: true
                    },
                ]
            });

        });
    </script>
</x-app-layout>
