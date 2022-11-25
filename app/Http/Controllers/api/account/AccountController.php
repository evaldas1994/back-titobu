<?php

namespace App\Http\Controllers\api\account;

use App\Http\Requests\account\AccountStoreUpdateRequest;
use App\Http\Resources\account\AccountCollection;
use App\Http\Resources\account\AccountResource;
use App\Services\account\AccountService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Account;

class AccountController extends Controller
{
    private AccountService $accountService;

    public function __construct()
    {
        $this->accountService = new AccountService();
    }

    public function index(): JsonResponse
    {
        $accounts = Account::whereUserId(auth()->id())
            ->orderBy('created_at', 'desc')
            ->simplePaginate();

        return response()->json((new AccountCollection($accounts)));
    }

    public function store(AccountStoreUpdateRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated = $this->accountService->addUser($validated);

        $account = $this->accountService->store($validated);

        return response()->json(new AccountResource($account), 201);
    }

    public function show(Account $account): JsonResponse
    {
        return response()->json(new AccountResource($account));
    }

    public function update(AccountStoreUpdateRequest $request, Account $account): JsonResponse
    {
        $validated = $request->validated();
        $validated = $this->accountService->addUser($validated);

        $account = $this->accountService->update($account, $validated);

        return response()->json(new AccountResource($account));
    }

    public function destroy(Account $account): JsonResponse
    {
        $this->accountService->delete($account);

        return response()->json(null, 204);
    }
}
