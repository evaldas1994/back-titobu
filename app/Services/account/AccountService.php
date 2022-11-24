<?php

namespace App\Services\account;

use App\Services\Service;
use App\Models\Account;

class AccountService extends Service
{
    public function store(array $validated): Account
    {
        return Account::create($validated);
    }

    public function update(Account $account, array $validated): Account
    {
        $account->update($validated);

        return $account;
    }

    public function delete(Account $account): void
    {
        $account->delete();
    }
}
