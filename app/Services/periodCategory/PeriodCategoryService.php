<?php

namespace App\Services\periodCategory;

use App\Models\PeriodCategory;
use App\Services\Service;

class PeriodCategoryService extends Service
{
    public function store(array $validated)
    {
        return PeriodCategory::create($validated);
    }

    public function update(PeriodCategory $periodCategory, array $validated): PeriodCategory
    {
        $periodCategory->update($validated);

        return $periodCategory;
    }

    public function delete(PeriodCategory $periodCategory): void
    {
        $periodCategory->delete();
    }
}
