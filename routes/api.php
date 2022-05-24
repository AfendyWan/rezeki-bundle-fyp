<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\auth\UserController;
use App\Http\Controllers\Api\settings\SettingsController;
use App\Http\Controllers\Api\saleItem\SaleItemController;
use App\Http\Controllers\Api\wishlist\WishListController;
use App\Http\Controllers\Api\cart\CartController;
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


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    //Authentication
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'settings'
], function ($router) {
   
    Route::get('showAllStates', [SettingsController::class, 'showAllStates']);
    Route::get('showAllCities', [SettingsController::class, 'showAllCities']);

});

Route::group([
    'middleware' => 'api',
    'prefix' => 'saleItem'
], function ($router) {
    //saleItem
    Route::get('showFirstThreeSaleItemCategory', [SaleItemController::class, 'showFirstThreeSaleItemCategory']);
    Route::get('showAllSsaleItemCategory', [SaleItemController::class, 'showAllSsaleItemCategory']);
    Route::get('showSaleItemList/{id}', [SaleItemController::class, 'showSaleItemList']);
    Route::get('showSaleItemImages/{id}', [SaleItemController::class, 'showSaleItemImages']);
    Route::get('showSaleItemPromotionList', [SaleItemController::class, 'showSaleItemPromotionList']);
    
    
    Route::get('showAllSaleItem', [SaleItemController::class, 'showAllSaleItem']);
    Route::post('store', [SaleItemController::class, 'store']);
    Route::delete('deleteSaleItem/{id}', [SaleItemController::class, 'destroy']);
    Route::post('updateSaleItem/', [SaleItemController::class, 'updateSaleItem']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'wishList'
], function ($router) {
    //saleItem
    Route::get('isWishList', [WishListController::class, 'isWishList']);
    Route::get('toggleWishList', [WishListController::class, 'toggleWishList']);
    Route::get('getUserWishList/{id}', [WishListController::class, 'getUserWishList']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'cart'
], function ($router) {
    //saleItem
    Route::get('getUserCartItem', [CartController::class, 'getUserCartItem']);
    Route::get('getUserCart', [CartController::class, 'getUserCart']);
    Route::get('deletCartItem', [CartController::class, 'deletCartItem']);
});

