<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\CreateOrderRequest;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\Order\MinPriceResource;
use App\Http\Resources\Order\OrderCreatedResource;
use App\Http\Resources\Order\OrderDeletedResource;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Order\OrderUpdatedResource;
use App\Http\Resources\Order\ShowOrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{

    public function index(OrderRequest $request) {
        $orders = OrderService::index($request);

        return OrderResource::collection($orders);
    }

    public function store(CreateOrderRequest $request) {
        $total = OrderService::calcTotal($request);
        if ($total < 3000) return MinPriceResource::make([]);

        $orders = OrderService::store($request);

        $orders->total = $total;

        return OrderCreatedResource::make($orders);
    }

    public function show(Order $order) {
        $total = 0;

        foreach ($order->products as $product) {
            $total += $product->pivot->amount * $product->price;
        }

        $order->total = round($total,2);

        return ShowOrderResource::make($order);
    }

    public function update(UpdateOrderRequest $request, Order $order) {
        $order = OrderService::update($request, $order);

        $total = 0;

        foreach ($order->products as $product) {
            $total += $product->pivot->amount * $product->price;
        }

        $order->total = round($total,2);

        return OrderUpdatedResource::make($order);
    }

    public function destroy(Order $order) {
        $order->delete();

        return OrderDeletedResource::make([]);
    }


    public function getOrders(Request $request) {
        $data = Order::latest()->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
