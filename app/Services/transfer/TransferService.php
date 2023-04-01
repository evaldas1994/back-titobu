<?php

namespace App\Services\transfer;

use App\Models\Period;
use App\Services\Service;
use App\Models\Transfer;
use Carbon\Carbon;

class TransferService extends Service
{
    public function store(array $validated): Transfer
    {
        $validated = $this->setPeriodId($validated);

        return Transfer::create($validated);
    }

    public function update(Transfer $transfer, array $validated): Transfer
    {
        $validated = $this->setPeriodId($validated);

        $transfer->update($validated);

        return $transfer;
    }

    public function delete(Transfer $transfer): void
    {
        $transfer->delete();
    }

    public function setPeriodId(array $validated): array
    {
        if (isset($validated['period_id']))
            return $validated;

        $period = Carbon::today()->format('Y-m');
        $periodId = Period::where('period', $period)?->first()?->id;

        $validated['period_id'] = $periodId;

        return $validated;
    }
}
