<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\auth\UserController;
use App\Http\Controllers\Api\settings\SettingsController;
use App\Http\Controllers\Api\saleItem\SaleItemController;
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
    
    Route::get('showAllSaleItem', [SaleItemController::class, 'showAllSaleItem']);
    Route::post('store', [SaleItemController::class, 'store']);
    Route::delete('deleteSaleItem/{id}', [SaleItemController::class, 'destroy']);
    Route::post('updateSaleItem/', [SaleItemController::class, 'updateSaleItem']);
});
