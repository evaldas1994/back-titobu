<?php

namespace App\Services\transfer;

use App\Services\Service;
use App\Models\Transfer;

class TransferService extends Service
{
    public function store(array $validated): Transfer
    {
        return Transfer::create($validated);
    }

    public function update(Transfer $transfer, array $validated): Transfer
    {
        $transfer->update($validated);

        return $transfer;
    }

    public function delete(Transfer $transfer): void
    {
        $transfer->delete();
    }
}
