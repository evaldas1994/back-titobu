<?php

namespace App\Http\Controllers\api\analytics;

use App\Http\Resources\analytics\analyticByCategory\AnalyticByCategoryAnalyticsCollection;
use App\Http\Resources\analytics\expenseByCategory\ExpenseByCategoryAnalyticsCollection;
use App\Http\Controllers\Controller;
use App\Services\Service;
use Illuminate\Http\JsonResponse;
use App\Models\Category;
use App\Models\Period;
use Carbon\Carbon;

class AnalyticByCategoryAnalyticsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $service = new Service();

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
            $data->purpose_id = 1;
            $data->icon = $category->icon;
            $data->color = $category->color;

            $data->balance_expenses = $category->transfers->pluck('amount')->sum();
            $data->balance_month = $category->pivot->limit;

            $data->balance_day = $service->floatFormat($data->balance_month / Carbon::now()->daysInMonth);

            $data->balance = $data->balance_month - $data->balance_expenses;
            $data->balance_today = $this->getBalanceToday($data);

            $result->push($data);
        }

        return response()->json((new AnalyticByCategoryAnalyticsCollection($result)));
    }

    private function getBalanceToday($data)
    {
        $expected = $data->balance_month - ($data->balance_day * Carbon::now()->day);
        $fact = $data->balance_month - $data->balance_expenses;

        return $fact - $expected;
    }
}
