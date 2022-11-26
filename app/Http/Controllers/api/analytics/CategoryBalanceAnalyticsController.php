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
        $categories = Category::whereUserId(auth()->id())
            ->wherePurposeId(1)
            ->whereType(Category::TYPE_OUT)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json((new CategoryBalanceAnalyticsCollection($categories)));
    }
}
