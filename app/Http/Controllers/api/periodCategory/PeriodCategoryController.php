<?php

namespace App\Http\Controllers\api\periodCategory;

use App\Http\Requests\periodCategory\PeriodCategoryStoreUpdateRequest;
use App\Http\Resources\periodCategory\PeriodCategoryCollection;
use App\Http\Resources\periodCategory\PeriodCategoryResource;
use App\Services\periodCategory\PeriodCategoryService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\PeriodCategory;

class PeriodCategoryController extends Controller
{
    private PeriodCategoryService $periodService;

    public function __construct()
    {
        $this->periodCategoryService = new PeriodCategoryService();
    }

    public function index(): JsonResponse
    {
        $periodCategories = PeriodCategory::whereUserId(auth()->id())
            ->orderBy('created_at', 'desc')
            ->simplePaginate();

        return response()->json((new PeriodCategoryCollection($periodCategories)));
    }

    public function store(PeriodCategoryStoreUpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated = $this->periodCategoryService->addUser($validated);

        $periodCategory = $this->periodCategoryService->store($validated);

        return response()->json(new PeriodCategoryResource($periodCategory), 201);
    }

    public function show(PeriodCategory $periodCategory): JsonResponse
    {
        return response()->json(new PeriodCategoryResource($periodCategory));
    }

    public function update(PeriodCategoryStoreUpdateRequest $request, PeriodCategory $periodCategory): JsonResponse
    {
        $validated = $request->validated();
        $validated = $this->periodCategoryService->addUser($validated);

        $periodCategory = $this->periodCategoryService->update($periodCategory, $validated);

        return response()->json(new PeriodCategoryResource($periodCategory));
    }

    public function destroy(PeriodCategory $periodCategory): JsonResponse
    {
        $this->periodCategoryService->delete($periodCategory);

        return response()->json(null, 204);
    }
}
