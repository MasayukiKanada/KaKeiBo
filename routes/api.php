<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Partner;
use App\Http\Controllers\Api\ChartController;
use App\Http\Controllers\ChartController as ControllersChartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')
->get('/searchPartners', function (Request $request) {
    return Partner::searchPartners($request->search)
    ->select('id', 'name')->get();
});

Route::middleware('auth:sanctum')->get('/chart', [ChartController::class, 'chart'])
->name('api.chart');

Route::middleware('auth:sanctum')->get('/table', [ChartController::class, 'table'])
->name('api.table');
