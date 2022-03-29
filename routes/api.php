<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\saleItem\SaleItemController;
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

Route::group([
    'middleware' => 'api',
    'prefix' => 'saleItem'
], function ($router) {
    //saleItem
    Route::get('showAllSaleItem', [SaleItemController::class, 'showAllSaleItem']);
    Route::post('store', [SaleItemController::class, 'store']);
    Route::delete('deleteSaleItem/{id}', [SaleItemController::class, 'destroy']);
    Route::post('updateSaleItem/', [SaleItemController::class, 'updateSaleItem']);
});
