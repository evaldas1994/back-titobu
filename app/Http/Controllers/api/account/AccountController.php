<?php

namespace App\Http\Controllers\api\account;

use App\Http\Requests\account\AccountStoreUpdateRequest;
use App\Http\Resources\account\AccountCollection;
use App\Http\Resources\account\AccountResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Account;

class AccountController extends Controller
{
    public function index(): JsonResponse
    {
        $accounts = Account::simplePaginate();

        return response()->json((new AccountCollection($accounts)));
    }

    public function store(AccountStoreUpdateRequest $request): JsonResponse
    {
        $account = Account::create($request->validated());

        return response()->json(new AccountResource($account), 201);
    }

    public function show(Account $account): JsonResponse
    {
        return response()->json(new AccountResource($account));
    }

    public function update(AccountStoreUpdateRequest $request, Account $account): JsonResponse
    {
        $account->update($request->validated());

        return response()->json(new AccountResource($account));
    }

    public function destroy(Account $account): JsonResponse
    {
        $account->delete();

        return response()->json(null, 204);
    }
}
