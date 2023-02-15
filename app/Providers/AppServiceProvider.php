<?php

namespace App\Providers;

use App\Models\Kiosk;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;

use Illuminate\Support\ServiceProvider;

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
    }
}
