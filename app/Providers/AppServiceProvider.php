<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
        if (env('REDIRECT_HTTPS')) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
   //         if (env('REDIRECT_HTTPS')) {
      //          $url->formatScheme('https://');
       //     }
        if (env('APP_ENV')!== 'local') {
            URL::forceScheme('https');
        }else{
            URL::forceScheme('http');
        }
    }
}