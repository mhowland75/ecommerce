<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Product;
use App\Basket;
use View;
use Config;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        //View::share('basketTotal', Basket::basketTotal());
         View::share('navBar', Product::navBar());
         View::composer('*', function($view){
            $view->with('basketTotal', Basket::basketTotal());
         });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
