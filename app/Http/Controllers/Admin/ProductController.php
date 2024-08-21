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
        $products = (new Product())->newQuery();
        if ($search = request()->input('search')) {
            $products->where('name', 'Like', '%' . $search . '%');
        } else {
            $products->latest();
        }
        $products = $products->with('category')->paginate(config('admin.paginate.per_page'))
            ->onEachSide(config('admin.paginate.each_side'))
            ->appends(request()->query());

        return inertia("Admin/Product/Index", compact("products"));
    }

    public function edit(int $id)
    {
        $product = Product::where('id', $id)->get()->first();
        $categories = Category::all();

        return inertia("Admin/Product/Edit", compact("product", "categories"));
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
        $product = Product::where('id', $request->get('id'))->get()->first();
        $product->fill($request->validated())->save();

        return Redirect::route('products.index');
    }

    public function destroy(DeleteProductRequest $request)
    {
        $product = Product::where('id', $request->get('id'))->get()->first();
        $product->delete();

        return ProductResource::make($product)->resolve();
    }
}
