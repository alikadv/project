<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::group(['prefix' => 'v1'], function () {
    Route::post('/sensors/{uuid}/mesurements', [App\Http\Controllers\MetricController::class, 'collect']);
    Route::get('/sensors/{uuid}', [App\Http\Controllers\MetricController::class, 'status']);
    Route::get('sensors/{uuid}/metrics', [App\Http\Controllers\MetricController::class, 'metrics']);
    Route::get('sensors/{uuid}/alerts', [App\Http\Controllers\MetricController::class, 'alerts']);


});


