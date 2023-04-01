<?php

namespace App\Http\Controllers\api\analytics;

use App\Http\Resources\analytics\categoryByType\CategoryByTypeAnalyticsCollection;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Models\Category;

class CategoryByTypeAnalyticsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $categories = Category::all();
        $categoriesByTypes = $categories->groupBy('type');

        $result = collect();
        foreach ($categoriesByTypes as $key => $categoriesByType)
        {
            $data = collect();
            $data->id = $key;
            $data->count = count($categoriesByType);

            $result->push($data);
        }

        return response()->json((new CategoryByTypeAnalyticsCollection($result)));
    }
}
