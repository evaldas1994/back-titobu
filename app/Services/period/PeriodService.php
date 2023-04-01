<?php

namespace App\Services\period;

use App\Services\Service;
use App\Models\Period;

class PeriodService extends Service
{
    public function store(array $validated)
    {
        return Period::create($validated);
    }

    public function update(Period $period, array $validated): Period
    {
        $period->update($validated);

        return $period;
    }

    public function delete(Period $period): void
    {
        $period->delete();
    }
}
