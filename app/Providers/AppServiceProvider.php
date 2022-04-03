<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use App\Models\Cart;
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
        View::composer('dashboards.users.layouts.user-dash-layout', function( $view )
        {
            $cartQuantity= Cart::where([
                ['userID', '=', Auth::user()->id],
                ['cartStatus', '=', '1'],
            ])->first();
            $view->with('cartQuantity', $cartQuantity );
            //pass the data to the view
            
        } );
    }
}
