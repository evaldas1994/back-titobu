<?php

namespace App\Services\analytics;

use Illuminate\Http\JsonResponse;
use App\Services\Service;
use App\Models\Category;
use App\Models\Period;
use Carbon\Carbon;

class EarningByCategoryAnalyticsService
{
    public function getTotalOfThisPeriod(): float|JsonResponse
    {
        $service = new Service();

        $period = Period::where('period', Carbon::now()->format('Y-m'))
            ->with(['categories', 'categories.transfers'])
            ->first();

        if (!$period)
            return response()->json((['No period found!']), 422);

        $total = $period->categories
            ->where('type', Category::TYPE_IN)
            ->pluck('transfers')
            ->collapse()
            ->where('period_id', $period->id)
            ->pluck('amount')
            ->sum();

        return $total;
    }
}
