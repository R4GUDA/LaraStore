<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\OrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(OrderRequest $request) {
        $orders = OrderService::index($request);

        return view('orders', [
            'orders' => $orders
        ]);
    }

    public function show(Order $order) {
        $total = 0;

        foreach ($order->products as $product) {
            $total += $product->pivot->amount * $product->price;
        }

        return view('order', [
            'order' => $order,
            'total' => $total
        ]);
    }

    public function update(UpdateOrderRequest $request, Order $order) {
        OrderService::update($request, $order);

        return back();
    }

    public function destroy(Order $order) {
        $order->delete();

        return redirect(route('order.index'));
    }

    public function find(Request $request) {
        $order = Order::whereSecret($request->secret)->first();

        if(!$order) return back();

        $total = 0;

        foreach ($order->products as $product) {
            $total += $product->pivot->amount * $product->price;
        }

        return view('find', [
            'order' => $order,
            'total' => $total
        ]);
    }
}
