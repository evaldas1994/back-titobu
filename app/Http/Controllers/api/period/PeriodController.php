<?php

namespace App\Http\Controllers\api\period;

use App\Http\Requests\period\PeriodStoreUpdateRequest;
use App\Http\Resources\period\PeriodCollection;
use App\Http\Resources\period\PeriodResource;
use App\Services\period\PeriodService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Period;

class PeriodController extends Controller
{
    private PeriodService $periodService;

    public function __construct()
    {
        $this->periodService = new PeriodService();
    }

    public function index(): JsonResponse
    {
        $periods = Period::whereUserId(auth()->id())
            ->orderBy('created_at', 'desc')
            ->simplePaginate();

        return response()->json((new PeriodCollection($periods)));
    }

    public function store(PeriodStoreUpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated = $this->periodService->addUser($validated);

        $period = $this->periodService->store($validated);

        return response()->json(new PeriodResource($period), 201);
    }

    public function show(Period $period): JsonResponse
    {
        return response()->json(new PeriodResource($period));
    }

    public function update(PeriodStoreUpdateRequest $request, Period $period): JsonResponse
    {
        $validated = $request->validated();
        $validated = $this->periodService->addUser($validated);

        $period = $this->periodService->update($period, $validated);

        return response()->json(new PeriodResource($period));
    }

    public function destroy(Period $period): JsonResponse
    {
        $this->periodService->delete($period);

        return response()->json(null, 204);
    }
}
