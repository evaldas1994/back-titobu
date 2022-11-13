<?php

namespace App\Http\Controllers\api\analytics;

use App\Http\Resources\analytics\categoryBalance\CategoryBalanceAnalyticsCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Category;

class CategoryBalanceAnalyticsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $categories = Category::where('type', '=', Category::TYPE_OUT)->get();

        return response()->json((new CategoryBalanceAnalyticsCollection($categories)));
    }
}
