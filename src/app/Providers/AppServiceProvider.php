<?php

namespace App\Providers;

use App\Services\FriendService;
use App\Services\MapperService;
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
        $this->app->singleton(MapperService::class, function ($app) {
            return new MapperService();
        });


        $this->app->singleton(FriendService::class, function ($app) {
            return new FriendService($app->make(MapperService::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
