<?php

namespace App\Http\Controllers\api\analytics;

use App\Http\Resources\analytics\earningByCategory\EarningByCategoryAnalyticsCollection;
use App\Http\Resources\analytics\periodByCategory\PeriodByCategoryAnalyticsCollection;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Models\Period;

class EarningByCategoryAnalyticsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $period = Period::where('period', Carbon::now()->format('Y-m'))
            ->with(['categories', 'categories.transfers'])
            ->first();

        if (!$period)
            return response()->json((['No period found!']), 422);

        $result = collect();
        $result->total = $period->categories->where('type', Category::TYPE_IN)->pluck('transfers')->collapse()->pluck('amount')->sum();

        foreach ($period->categories->where('type', Category::TYPE_IN) as $key => $category) {
            $data = collect();

            $data->id = $category->id;
            $data->name = $category->name;
            $data->amount = $category->transfers->where('period_id', $period->f_id)->pluck('amount')->sum();
            $data->color = $category->color;

            $result->push($data);
        }

        return response()->json((new EarningByCategoryAnalyticsCollection($result)));
    }
}
