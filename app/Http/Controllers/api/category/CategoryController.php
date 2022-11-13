<?php

namespace App\Http\Controllers\api\category;

use App\Http\Requests\category\CategoryStoreUpdateRequest;
use App\Http\Resources\category\CategoryCollection;
use App\Http\Resources\category\CategoryResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::simplePaginate();

        return response()->json((new CategoryCollection($categories)));
    }

    public function store(CategoryStoreUpdateRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());

        return response()->json(new CategoryResource($category), 201);
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json(new CategoryResource($category));
    }

    public function update(CategoryStoreUpdateRequest $request, Category $category): JsonResponse
    {
        $category->update($request->validated());

        return response()->json(new CategoryResource($category));
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json(null, 204);
    }
}
