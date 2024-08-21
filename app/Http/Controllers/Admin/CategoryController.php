<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeleteCategoryRequest;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return inertia("Admin/Category/Index", compact("categories"));
    }

    public function add()
    {
        $categories = Category::all();
        return inertia("Admin/Category/Add", compact("categories"));
    }

    public function edit(int $id)
    {
        if (!($category = Category::where('id', $id)->get()->first())) {
            return abort(404);
        }

        return inertia("Admin/Category/Edit", compact("category"));
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->validated());

        return Redirect::route('categories.index');
    }

    public function update(UpdateProductRequest $request): RedirectResponse
    {
        if (!($category = Category::where('id', $request->get('id'))->get()->first())) {
            return abort(404);
        }
        $category->fill($request->validated())->save();

        return Redirect::route('categories.edit');
    }

    public function destroy(DeleteCategoryRequest $request)
    {
        if (!($category = Category::where('id', $request->get('id'))->get()->first())) {
            return abort(404);
        }

        $category->delete();

        return CategoryResource::make($category)->resolve();
    }
}
