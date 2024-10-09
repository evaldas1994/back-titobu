<?php

use App\Http\Controllers\api\analytics\BalanceByThisPeriodEarningsAnalyticsController;
use App\Http\Controllers\api\analytics\AnalyticByCategoryAnalyticsController;
use App\Http\Controllers\api\analytics\BalanceByThisPeriodAnalyticsController;
use App\Http\Controllers\api\analytics\EarningByCategoryAnalyticsController;
use App\Http\Controllers\api\analytics\ExpenseByCategoryAnalyticsController;
use App\Http\Controllers\api\analytics\PeriodByCategoryAnalyticsController;
use App\Http\Controllers\api\analytics\CategoryByTypeAnalyticsController;
use App\Http\Controllers\api\periodCategory\PeriodCategoryController;
use App\Http\Controllers\api\transfer\TransferController;
use App\Http\Controllers\api\category\CategoryController;
use App\Http\Controllers\api\period\PeriodController;
use App\Http\Controllers\api\auth\LogoutController;
use App\Http\Controllers\api\auth\LoginController;
use App\Http\Controllers\api\user\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/tokens/create', [LoginController::class, 'tokensCreate']);

//modules

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

Route::middleware(['auth:sanctum'])
    ->name('api.')
    ->group(function ($router) {
        $router->get('/user', [LoginController::class, 'user']);

        $router->apiResource('users', UserController::class);
        $router->apiResource('categories', CategoryController::class);
        $router->apiResource('periods', PeriodController::class);
        $router->apiResource('period-categories', PeriodCategoryController::class);

        $router->apiResource('transfers', TransferController::class);
        $router->get('transfers/by-category/{category}', [TransferController::class, 'indexByCategory']);

        $router->prefix('analytics')->name('analytics.')->group(function ($router2) {
//            $router2->get('balance-by-this-period', BalanceByThisPeriodAnalyticsController::class);
//            $router2->get('balance-by-this-period-earnings', BalanceByThisPeriodEarningsAnalyticsController::class);
            $router2->get('category-by-type', CategoryByTypeAnalyticsController::class);
            $router2->get('period-by-category', PeriodByCategoryAnalyticsController::class);
            $router2->get('earning-by-category', EarningByCategoryAnalyticsController::class);
            $router2->get('expense-by-category', ExpenseByCategoryAnalyticsController::class);
            $router2->get('analytic-by-category', AnalyticByCategoryAnalyticsController::class);
        });

        $router->get('logout', [LogoutController::class, 'logout']);
    });

//crons
Route::get('/new-period', [\App\Jobs\NewPeriod::class, 'handle']);
Route::get('/end-of-period', [\App\Jobs\EndOfPeriod::class, 'handle']);


// test git webhook 6
