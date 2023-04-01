<?php

namespace App\Http\Controllers\api\analytics;

use App\Http\Resources\analytics\balanceByThisPeriod\BalanceByThisPeriodTotalResource;
use App\Http\Resources\analytics\categoryBalance\CategoryBalanceAnalyticsCollection;
use App\Http\Controllers\Controller;
use App\Models\Period;
use App\Models\Transfer;
use App\Services\analytics\CategoryBalanceService;
use App\Services\Service;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Models\Category;

class BalanceByThisPeriodEarningsAnalyticsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $service = new Service();

        $currentMonth = Carbon::now()->format('Y-m');

        $period = Period::where('period', '=', $currentMonth)->first();
        if (!$period) return response()->json(null, 404);;

        $transfers = Transfer::where('user_id', auth()->id())
            ->where('period_id', $period->id)
            ->with(['category'])
            ->get();

        $earnings = $transfers->where('category.type', Category::TYPE_IN);
        $expenses = $transfers->where('category.type', Category::TYPE_OUT);

        $categories = $expenses->groupBy('category.id');
dd($categories);

        $results = collect();
        $results->earnings = $service->floatFormat($earnings->pluck('amount')->sum());
        $results->expenses = $service->floatFormat($expenses->pluck('amount')->sum());

        return response()->json((new BalanceByThisPeriodTotalResource($results)));
    }
}
