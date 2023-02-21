<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    public function index() {
        $products = Product::latest()->paginate(12);

        return view('products', [
            'products' => $products
        ]);
    }

    public function store(CreateProductRequest $request): RedirectResponse {
        Product::create($request->all());

        return back();
    }

    public function show(Product $product): View {
        return view('product', [
            'product' => $product
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse {
        $product->update($request->all());

        return back();
    }

    public function destroy(Product $product) {
        $product->delete();

        return redirect(route('product.index'));
    }

}
