<?php

use App\Http\Controllers\ApiController\AuthController;
use App\Http\Controllers\ApiController\CartApiController;
use App\Http\Controllers\ApiController\CategoryApiController;
use App\Http\Controllers\ApiController\OrderApiController;
use App\Http\Controllers\ApiController\ProductApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::apiResource('products', ProductApiController::class);
Route::apiResource('categories', CategoryApiController::class);
Route::apiResource('carts', CartApiController::class)->middleware(['auth:sanctum']);
Route::apiResource('orders', OrderApiController::class)->middleware(['auth:sanctum']);

Route::post('login',[AuthController::class,'login']);
Route::post('logout',[AuthController::class,'logout']);
