<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\RekognitionService;

class RekognitionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RekognitionService::class, function ($app) {
            return new RekognitionService();
        });
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
