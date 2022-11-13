<?php

use App\Http\Controllers\api\analytics\CategoryBalanceAnalyticsController;
use App\Http\Controllers\api\category\CategoryController;
use App\Http\Controllers\api\transfer\TransferController;
use App\Http\Controllers\api\account\AccountController;
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

        $router->resource('users', UserController::class);
        $router->resource('accounts', AccountController::class);
        $router->resource('categories', CategoryController::class);

        $router->prefix('transfers')->name('transfers.')->group(function ($router2) {
            $router2->prefix('get-by-category')->group(function ($router3) {
                $router3->get('{category_id}', [TransferController::class, 'getByCategory']);
            });
        });
        $router->resource('transfers', TransferController::class);

        $router->prefix('analytics')->name('analytics.')->group(function ($router2) {
            $router2->get('out-category-balance', CategoryBalanceAnalyticsController::class);
        });

        $router->get('logout', [LogoutController::class, 'logout']);
    });
