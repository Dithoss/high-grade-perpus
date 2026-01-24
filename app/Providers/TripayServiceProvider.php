<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TripayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            config_path('tripay.php'),
            'tripay'
        );
    }


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
