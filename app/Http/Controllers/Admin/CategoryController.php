<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeleteCategoryRequest;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = (new Category())->newQuery();
        if ($search = request()->input('search')) {
            $categories->where('name', 'Like', '%' . $search . '%');
        } else {
            $categories->latest();
        }
        $categories = $categories->paginate(config('admin.paginate.per_page'))
            ->onEachSide(config('admin.paginate.each_side'))
            ->appends(request()->query());

        return inertia("Admin/Category/Index", compact("categories", "search"));
    }

    public function add()
    {
        $categories = Category::all();
        return inertia("Admin/Category/Add", compact("categories"));
    }

    public function edit(int $id)
    {
        $category = Category::where('id', $id)->get()->first();

        return inertia("Admin/Category/Edit", compact("category"));
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return Redirect::route('categories.index');
    }

    public function update(UpdateCategoryRequest $request)
    {
        $category = Category::where('id', $request->get('id'))->get()->first();

        $category->fill($request->validated())->save();

        return Redirect::route('categories.index');
    }

    public function destroy(DeleteCategoryRequest $request)
    {
        $category = Category::where('id', $request->get('id'))->get()->first();

        $category->delete();

        return CategoryResource::make($category)->resolve();
    }
}
