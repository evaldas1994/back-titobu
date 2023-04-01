<?php

namespace App\Http\Controllers\api\analytics;

use App\Http\Resources\analytics\periodByCategory\PeriodByCategoryAnalyticsCollection;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\JsonResponse;
use App\Models\Period;

class PeriodByCategoryAnalyticsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $periods = Period::with(['categories'])
            ->orderBy('period', 'desc')
            ->limit(2)
            ->get();

        $periods = $periods->reverse();

        $result = collect();
        foreach ($periods as $key => $period) {
            $data = collect();
            $data->id = $period->id;
            $data->period = $period->period;
            $data->count = $period->categories->count();
            $data->categories_in = $period->categories?->where('type', Category::TYPE_IN);

            $data->categories_in_without_balance = Category::where('type', '=', Category::TYPE_IN)
                ->whereUserId(auth()->id())
                ->whereNotIn('id', $data->categories_in ? $data->categories_in->pluck('id')->toArray() : [])
                ->get();

            $data->categories_out = $period->categories->where('type', Category::TYPE_OUT);
            $data->categories_out_without_balance = Category::where('type', Category::TYPE_OUT)
                ->whereUserId(auth()->id())
                ->whereNotIn('id', $data->categories_out ? $data->categories_out->pluck('id')->toArray() : [])
                ->get();

            $data->balance = $data->categories_out?->pluck('pivot.limit')->sum();

            $result->push($data);
        }

        return response()->json((new PeriodByCategoryAnalyticsCollection($result)));
    }
}
