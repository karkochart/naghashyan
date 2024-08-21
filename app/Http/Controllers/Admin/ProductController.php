<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeleteProductRequest;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return inertia("Admin/Product/Index", compact("products"));
    }

    public function edit(int $id)
    {
        if (!($product = Product::where('id', $id)->get()->first())) {
            return abort(404);
        }

        return inertia("Admin/Product/Edit", compact("product"));
    }

    public function add()
    {
        $categories = Category::all();
        return inertia("Admin/Product/Add", compact("categories"));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        Product::create($request->validated());

        // TODO images

        return Redirect::route('products.index');
    }

    public function update(UpdateProductRequest $request): RedirectResponse
    {

        if (!($product = Product::where('id', $request->get('id'))->get()->first())) {
            return abort(404);
        }
        $product->fill($request->validated())->save();

        return Redirect::route('products.edit');
    }

    public function destroy(DeleteProductRequest $request)
    {
        if (!($product = Product::where('id', $request->get('id'))->get()->first())) {
            return abort(404);
        }

        $product->delete();

        return ProductResource::make($product)->resolve();
    }
}
