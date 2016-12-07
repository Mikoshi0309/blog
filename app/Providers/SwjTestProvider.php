<?php

namespace App\Providers;

use App\Contract\SwjTest;
use Illuminate\Support\ServiceProvider;

class SwjTestProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('SwjTest',function(){
           return new SwjTest;
        });
    }
}
