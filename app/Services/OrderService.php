<?php

namespace App\Services;

use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class OrderService
{
    public static function index(OrderRequest $request) : LengthAwarePaginator {
        $orders = Order::orderBy('id', 'desc');

        if ($request->date) $orders->whereDate('delivery_date', Carbon::parse($request->date));

        $orders = $orders->paginate($request->amount ?: 10);

        return $orders;
    }

    public static function store(CreateOrderRequest $request) : Order {

        $secret = Str::random(8);

        $order = Order::create($request->merge([
            'secret' => $secret,
            'delivery_date' => Carbon::parse($request->delivery_date)
        ])->all());

        $order->products()->attach($request->positions);

        return $order;
    }


    public static function update(UpdateOrderRequest $request, Order $order) : Order {
        $order->update($request->merge([
            'delivery_date' => Carbon::parse($request->delivery_date)
        ])->all());

        if ($request->positions) $order->products()->sync($request->positions);

        return $order;
    }

    public static function calcTotal($request) : float {
        $positions = [];

        foreach ($request->positions as $position) {
            $positions[] += $position['product_id'];
        }

        $products = Product::whereIn('id', $positions)->get();
        $total = 0;

        foreach ($products as $key => $item) {
            $total += $item->price * $request->positions[$key]['amount'];
        };

        return $total;
    }
}
