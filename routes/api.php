<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/get-orders', [\App\Http\Controllers\Api\OrderController::class, 'getOrders'])->name('getOrders');

Route::middleware('apiAuth')->group(function () {
    Route::apiResource('/order', \App\Http\Controllers\Api\OrderController::class);
});

Route::post('/order', [\App\Http\Controllers\Api\OrderController::class, 'store']);

Route::post('/login', [\App\Http\Controllers\Auth\ApiAuthenticateController::class, 'store']);
