<?php

namespace App\Providers;

use App\Utils\KeyWordFilter;
use Illuminate\Support\ServiceProvider;

class KeyWordFilterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('keywordFilter',function(){
            return new KeyWordFilter;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
