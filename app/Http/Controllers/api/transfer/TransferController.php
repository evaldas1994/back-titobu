<?php

namespace App\Http\Controllers\api\transfer;

use App\Http\Requests\transfer\TransferStoreUpdateRequest;
use App\Http\Resources\transfer\TransferCollection;
use App\Http\Resources\transfer\TransferResource;
use App\Services\transfer\TransferService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Transfer;

class TransferController extends Controller
{
    private TransferService $transferService;

    public function __construct()
    {
        $this->transferService = new TransferService();
    }

    public function index(): JsonResponse
    {
        $transfers = Transfer::whereUserId(auth()->id())
            ->orderBy('created_at', 'desc')
            ->simplePaginate();

        return response()->json((new TransferCollection($transfers)));
    }

    public function store(TransferStoreUpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated = $this->transferService->addUser($validated);

        $transfer = $this->transferService->store($validated);

        return response()->json(new TransferResource($transfer), 201);
    }

    public function show(Transfer $transfer): JsonResponse
    {
        return response()->json(new TransferResource($transfer));
    }

    public function update(TransferStoreUpdateRequest $request, Transfer $transfer): JsonResponse
    {
        $validated = $request->validated();
        $validated = $this->transferService->addUser($validated);

        $transfer = $this->transferService->update($transfer, $validated);

        return response()->json(new TransferResource($transfer));
    }

    public function destroy(Transfer $transfer): JsonResponse
    {
        $this->transferService->delete($transfer);

        return response()->json(null, 204);
    }

    public function getByCategory(int $categoryId): JsonResponse
    {
        $transfers = Transfer::whereUserId(auth()->id())
            ->whereCategoryId($categoryId)
            ->orderBy('created_at', 'desc')
            ->simplePaginate();

        return response()->json((new TransferCollection($transfers)));
    }
}
