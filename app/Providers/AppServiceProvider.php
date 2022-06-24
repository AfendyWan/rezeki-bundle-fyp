<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use App\Models\Cart;
use App\Models\SaleItem;
use App\Models\SaleItemCategory;
use Illuminate\Pagination\Paginator;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        View::composer('dashboards.users.layouts.user-dash-layout', function( $view )
        {
            $cartQuantity= Cart::where([
                ['userID', '=', Auth::user()->id],
                ['cartStatus', '=', '1'],
            ])->first();


            $brandList =  SaleItemCategory::all();
            $brandListFooter =  SaleItemCategory::all()->take(3);
           
            $view->with('cartQuantity', $cartQuantity )->with('brandList', $brandList)->with('brandListFooter', $brandListFooter);
            //pass the data to the view
            
        } );
    }
}
