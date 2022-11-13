<?php

namespace App\Http\Controllers\api\transfer;

use App\Http\Requests\transfer\TransferStoreUpdateRequest;
use App\Http\Resources\transfer\TransferCollection;
use App\Http\Resources\transfer\TransferResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Transfer;

class TransferController extends Controller
{
    public function index(): JsonResponse
    {
        $transfers = Transfer::orderBy('created_at', 'desc')->simplePaginate();

        return response()->json((new TransferCollection($transfers)));
    }

    public function store(TransferStoreUpdateRequest $request): JsonResponse
    {
        $transfer = Transfer::create($request->validated());

        return response()->json(new TransferResource($transfer), 201);
    }

    public function show(Transfer $transfer): JsonResponse
    {
        return response()->json(new TransferResource($transfer));
    }

    public function update(TransferStoreUpdateRequest $request, Transfer $transfer): JsonResponse
    {
        $transfer->update($request->validated());

        return response()->json(new TransferResource($transfer));
    }

    public function destroy(Transfer $transfer): JsonResponse
    {
        $transfer->delete();

        return response()->json(null, 204);
    }

    public function getByCategory(int $categoryId): JsonResponse
    {
        $transfers = Transfer::where('category_id', '=', $categoryId)->orderBy('created_at', 'desc')->simplePaginate();

        return response()->json((new TransferCollection($transfers)));
    }
}
