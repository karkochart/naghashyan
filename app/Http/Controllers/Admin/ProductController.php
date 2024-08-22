<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\IncorrectPhotoNumberException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeleteProductRequest;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Services\FileService;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

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
        $product = Product::where('id', $id)->with('photos')->get()->first();
        $categories = Category::all();

        return inertia("Admin/Product/Edit", compact("product", "categories"));
    }

    public function add()
    {
        $categories = Category::all();
        return inertia("Admin/Product/Add", compact("categories"));
    }

    public function store(StoreProductRequest $request, FileService $fileUploadService)
    {
        try {
            DB::transaction(function () use ($request, $fileUploadService) {
                /** @var Product $product */
                $product = Product::create($request->validated());
                $photosData = [];
                $files = $request->file('photos');
                foreach ($files as $file) {
                    $photosData[] = [
                        'product_id' => $product->id,
                        'path' => sprintf(
                            '%s/%s.%s',
                            $product->id,
                            Str::random(20),
                            $file->getClientOriginalExtension()
                        ),
                    ];
                }
                $photosModels = $product->photos()->createMany($photosData);
                $fileUploadService->uploadFiles($photosModels, $files);
            });
        } catch (\Exception $exception) {
            $message = true || $exception instanceof IncorrectPhotoNumberException ? $exception->getMessage() :
                'Bla bla bla image';
            return inertia("Admin/Product/Add", [
                "errors" => ['photos' => $message],
                "categories" => Category::all(),
            ]);
        }

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
