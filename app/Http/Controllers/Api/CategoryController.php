<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json(CategoryResource::collection($categories));
    }

    public function store(CategoryRequest $request) {
        $validatedData = $request->all();

        $category = Category::create($validatedData);

        return response()->json($category, 201);
    }

    public function update(CategoryRequest $request, Category $category) {
        $validatedData = $request->all();

        $category = tap($category)->update($validatedData);

        return response()->json(["updated" => $validatedData], 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json($category, 200);
    }
}
