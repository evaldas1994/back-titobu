<?php

namespace App\Http\Controllers\api\purpose;

use App\Http\Requests\purpose\PurposeStoreUpdateRequest;
use App\Http\Resources\purpose\PurposeCollection;
use App\Http\Resources\purpose\PurposeResource;
use App\Services\purpose\PurposeService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Purpose;

class PurposeController extends Controller
{
    private PurposeService $purposeService;

    public function __construct()
    {
        $this->purposeService = new PurposeService();
    }

    public function index(): JsonResponse
    {
        $purposes = Purpose::whereUserId(auth()->id())
            ->orderBy('created_at', 'desc')
            ->simplePaginate();

        return response()->json((new PurposeCollection($purposes)));
    }

    public function store(PurposeStoreUpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated = $this->purposeService->addUser($validated);

        $purpose = $this->purposeService->store($validated);

        return response()->json(new PurposeResource($purpose), 201);
    }

    public function show(Purpose $purpose): JsonResponse
    {
        return response()->json(new PurposeResource($purpose));
    }

    public function update(PurposeStoreUpdateRequest $request, Purpose $purpose): JsonResponse
    {
        $validated = $request->validated();
        $validated = $this->purposeService->addUser($validated);

        $purpose = $this->purposeService->update($purpose, $validated);

        return response()->json(new PurposeResource($purpose));
    }

    public function destroy(Purpose $purpose): JsonResponse
    {
        $this->purposeService->delete($purpose);

        return response()->json(null, 204);
    }
}
