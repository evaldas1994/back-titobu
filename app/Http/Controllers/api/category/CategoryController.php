<?php

namespace App\Http\Controllers\api\category;

use App\Http\Requests\category\CategoryStoreUpdateRequest;
use App\Http\Resources\category\CategoryCollection;
use App\Http\Resources\category\CategoryResource;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Services\category\CategoryService;
use App\Services\Service;
use Illuminate\Http\JsonResponse;
use App\Models\Category;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
    }

    public function index(): JsonResponse
    {
        $categories = Category::whereUserId(auth()->id())->simplePaginate();

        return response()->json((new CategoryCollection($categories)));
    }

    public function store(CategoryStoreUpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated = $this->categoryService->addUser($validated);

        $category = $this->categoryService->store($validated);

        return response()->json(new CategoryResource($category), 201);
    }

    public function show(Category $category): JsonResponse
    {
        return response()->json(new CategoryResource($category));
    }

    public function update(CategoryStoreUpdateRequest $request, Category $category): JsonResponse
    {
        $validated = $request->validated();
        $validated = $this->categoryService->addUser($validated);

        $category = $this->categoryService->update($category, $validated);

        return response()->json(new CategoryResource($category));
    }

    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json(null, 204);
    }
}
