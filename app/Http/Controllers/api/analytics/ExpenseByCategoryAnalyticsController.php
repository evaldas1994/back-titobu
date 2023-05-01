<?php

namespace App\Http\Controllers\api\analytics;

use App\Http\Resources\analytics\earningByCategory\EarningByCategoryAnalyticsCollection;
use App\Http\Resources\analytics\expenseByCategory\ExpenseByCategoryAnalyticsCollection;
use App\Http\Resources\analytics\periodByCategory\PeriodByCategoryAnalyticsCollection;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Models\Period;

class ExpenseByCategoryAnalyticsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $period = Period::where('period', Carbon::now()->format('Y-m'))
            ->with(['categories', 'categories.transfers'])
            ->first();

        if (!$period)
            return response()->json((['No period found!']), 422);

        $result = collect();
        foreach ($period->categories->where('type', Category::TYPE_OUT) as $key => $category) {
            $data = collect();

            $data->id = $category->id;
            $data->name = $category->name;
            $data->amount = $category->transfers->where('period_id', $period->id)->pluck('amount')->sum();
            $data->color = $category->color;

            $result->push($data);
        }

        return response()->json((new ExpenseByCategoryAnalyticsCollection($result)));
    }
}
