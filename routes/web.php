<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SaleItemCategoryController;
use App\Http\Controllers\SaleItemController;
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
    return view('welcome');
});

Route::middleware(['middleware'=>'PreventBackHistory'])->group(function(){
    Auth::routes();
});



// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'=> 'admin', 'middleware'=>['isAdmin','auth', 'PreventBackHistory']], function(){
      Route::get('dashboard',[AdminController::class,'index'])->name('admin.dashboard');
      Route::get('profile',[AdminController::class,'profile'])->name('admin.profile');
      Route::get('settings',[AdminController::class,'settings'])->name('admin.settings');
     
      Route::resource('manageCategories', SaleItemCategoryController::class);

      Route::get('toggleActivationStatus/{id}',[SaleItemController::class,'toggleActivationStatus'])->name('manageSaleItems.toggleActivationStatus');
      Route::resource('manageSaleItems', SaleItemController::class);
      //Route::get('manageCategories',[SaleItemCategoryController::class,'index'])->name('manageCategories.index');
     //Format Route::get('url naming',[Controller name::class,'index'])->name('route name');
    //  Route::get('logout', 'Auth\LoginController@logout');
});

Route::group(['prefix'=> 'user', 'middleware'=>['isUser','auth', 'PreventBackHistory']], function(){
    Route::get('dashboard',[UserController::class,'index'])->name('user.dashboard');
    Route::get('profile',[UserController::class,'profile'])->name('user.profile');
    Route::get('settings',[UserController::class,'settings'])->name('user.settings');
  //  Route::get('logout', 'Auth\LoginController@logout');
});

