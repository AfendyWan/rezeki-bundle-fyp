<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SaleItemCategoryController;
use App\Http\Controllers\SaleItemController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishListController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ReportController;

use Illuminate\Support\Facades\Auth;


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

Route::get('/', function () {
    if (Auth::check()) {
        if(Auth::user()->role == "1"){
            return redirect('admin/dashboard');            
        }
        else if(Auth::user()->role == "2"){
            return redirect('user/dashboard');            
        }
    }else{
        return view('auth/login');
    }
    
});

Route::middleware(['middleware'=>'PreventBackHistory'])->group(function(){
    Route::get('/registers', function () {
        $state = App\Models\State::all();
        return view('auth/register',['state' => $state]);
    });
    Auth::routes();
});



Route::get('getCities/{id}', function ($id) {
    $city = App\Models\City::where('states_id',$id)->get();
    return response()->json($city);
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'=> 'admin', 'middleware'=>['isAdmin','auth', 'PreventBackHistory']], function(){
    Route::get('dashboard',[ReportController::class,'index'])->name('admin.dashboard');
    Route::get('profile',[AdminController::class,'profile'])->name('admin.profile');
    Route::get('settings',[AdminController::class,'settings'])->name('admin.settings');
    Route::post('updateProfile',[AdminController::class,'updateProfile'])->name('admin.updateProfile');
    
    Route::resource('manageCategories', SaleItemCategoryController::class);

    Route::get('editPromotion/{id}',[SaleItemController::class,'editPromotion'])->name('manageSaleItems.editPromotion');
    Route::post('updatePromotion/{id}',[SaleItemController::class,'updatePromotion'])->name('manageSaleItems.updatePromotion');
    Route::get('toggleActivationStatus/{id}',[SaleItemController::class,'toggleActivationStatus'])->name('manageSaleItems.toggleActivationStatus');
    Route::resource('manageSaleItems', SaleItemController::class);

    Route::resource('manageTransactions', TransactionController::class);
    Route::get('verifyUserTransaction/',[TransactionController::class,'verifyUserTransaction'])->name('manageTransactions.verifyUserTransaction');
    Route::get('viewUserDailyTransaction/',[TransactionController::class,'viewUserDailyTransaction'])->name('manageTransactions.viewUserDailyTransaction');
    Route::get('viewOrderItems/{id}',[TransactionController::class,'viewOrderItems'])->name('manageTransactions.viewOrderItems');
    Route::get('viewUserOrder/{id}',[TransactionController::class,'viewUserOrder'])->name('manageTransactions.viewUserOrder');
    
    Route::get('redirect-with-date', [
        'as' => 'searchDateTransaction',
        'uses' => 'App\Http\Controllers\TransactionController@searchWithDate'
    ]);
    Route::get('adminSearchDateTransaction/{param1}/', [
        'as' => 'adminSearchDateTransaction',
        'uses' => 'App\Http\Controllers\TransactionController@adminSearchDateTransaction'
    ]);
    
    Route::post('updatePaymentVerificationStatus/',[PaymentController::class,'updatePaymentVerificationStatus'])->name('managePayments.updatePaymentVerificationStatus');

    Route::get('adminIndex',[FeedbackController::class,'adminIndex'])->name('manageFeedback.adminIndex');
    Route::delete('deleteFeedback/{id}',[FeedbackController::class,'deleteFeedback'])->name('manageFeedback.deleteFeedback');
    
    Route::get('adminShipmentIndex',[ShipmentController::class,'adminShipmentIndex'])->name('manageShipments.adminShipmentIndex');
    Route::get('adminUpdateShipment/{id}',[ShipmentController::class,'adminUpdateShipment'])->name('manageShipments.adminUpdateShipment');
    Route::post('adminSaveShipment/',[ShipmentController::class,'adminSaveShipment'])->name('manageShipments.adminSaveShipment');
    
      //Route::get('manageCategories',[SaleItemCategoryController::class,'index'])->name('manageCategories.index');
     //Format Route::get('url naming',[Controller name::class,'index'])->name('route name');
    //  Route::get('logout', 'Auth\LoginController@logout');
});

Route::group(['prefix'=> 'user', 'middleware'=>['isUser','auth', 'PreventBackHistory']], function(){
   
    Route::get('dashboard',[UserController::class,'index'])->name('user.dashboard');
    Route::get('profile',[UserController::class,'profile'])->name('user.profile');
    Route::post('updateProfile/',[UserController::class,'updateProfile'])->name('user.updateProfile');
        
    Route::get('settings',[UserController::class,'settings'])->name('user.settings');
    Route::get('viewSaleItemList/{id}',[SaleItemController::class,'userIndex'])->name('saleItems.index');
    Route::get('viewSaleItem/{id}',[SaleItemController::class,'userShowItem'])->name('saleItems.show');
    Route::get('viewSaleItemPromotionList',[SaleItemController::class,'userShowPromotionList'])->name('saleItems.showPromotionList');
   //Route::post('userSearchSaleItem/',[SaleItemController::class,'userSearchSaleItem'])->name('manageSaleItems.userSearchSaleItem');
         
    Route::get('redirect-with-params', [
        'as' => 'search',
        'uses' => 'App\Http\Controllers\SaleItemController@searchWithParams'
    ]);

    Route::get('userSearchSaleItem/{param1}/', [
        'as' => 'userSearchSaleItem',
        'uses' => 'App\Http\Controllers\SaleItemController@userSearchSaleItem'
    ]);
    
    Route::resource('manageCarts', CartController::class);
    Route::post('updateCartItemQuantity/',[CartController::class,'updateCartItemQuantity'])->name('manageCarts.updateCartItemQuantity');
    Route::post('deleteCartItem/',[CartController::class,'deleteCartItem'])->name('manageCarts.deleteCartItem');

    Route::resource('manageWishList', WishListController::class);
    Route::post('delete/',[WishListController::class,'delete'])->name('manageWishList.delete');

    Route::resource('managePayment', PaymentController::class);
    Route::get('index/',[PaymentController::class,'index'])->name('managePayments.index');
    Route::post('updatePaymentResult/',[PaymentController::class,'updatePaymentResult'])->name('managePayments.updatePaymentResult');

    Route::resource('manageShipments', ShipmentController::class);
    Route::get('updateShippingDefault/{id}',[ShipmentController::class,'updateShippingDefault'])->name('manageShipments.updateShippingDefault');    
    Route::post('addNewShippingAddress/',[ShipmentController::class,'addNewShippingAddress'])->name('manageShipments.addNewShippingAddress');
    Route::get('editShippingAddress/{id}',[ShipmentController::class,'editShippingAddress'])->name('manageShipments.editShippingAddress');
    Route::post('updateShippingAddress/',[ShipmentController::class,'updateShippingAddress'])->name('manageShipments.updateShippingAddress');
    Route::get('deleteShippingAddress/{id}',[ShipmentController::class,'deleteShippingAddress'])->name('manageShipments.deleteShippingAddress');
    
    Route::get('userIndex',[TransactionController::class,'userIndex'])->name('manageTransactions.userIndex');
    Route::get('userViewOrderItems/{id}',[TransactionController::class,'userViewOrderItems'])->name('manageTransactions.userViewOrderItems');
    
    Route::resource('manageFeedback', FeedbackController::class);

    Route::get('userShipmentIndex',[ShipmentController::class,'userShipmentIndex'])->name('manageShipments.userShipmentIndex');

  //  Route::get('logout', 'Auth\LoginController@logout');
});

