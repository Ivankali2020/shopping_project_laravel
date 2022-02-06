<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');
Route::get('detail/product', [App\Http\Controllers\HomeController::class, 'detail'])->name('detail.product');
Route::get('user/cart', [App\Http\Controllers\HomeController::class, 'UserCart'])->name('user.cart');

Route::group(['middleware' => ['auth']],function (){

    Route::resource('category',\App\Http\Controllers\CategoryController::class);
    Route::resource('brand',\App\Http\Controllers\BrandController::class);
    Route::resource('user',\App\Http\Controllers\UserController::class);
    Route::resource('product',\App\Http\Controllers\ProductController::class);
    Route::resource('cart',\App\Http\Controllers\CartController::class);
    Route::resource('order',\App\Http\Controllers\OrderController::class);
    Route::post('/user/upgradeAdmin', [\App\Http\Controllers\UserController::class, 'upgradeAdmin'])->name('user.upgradeAdmin');

});

Route::get('/redirect/{name}',[\App\Http\Controllers\Auth\LoginController::class,'redirect'])->name('redirect.name');
Route::get('/callback/{name}',[\App\Http\Controllers\Auth\LoginController::class,'callBack'])->name('callback.name');

Route::post('product/heart/',[\App\Http\Controllers\ProductController::class,'heartGive'])->name('product.heart');
