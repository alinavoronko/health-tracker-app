<?php

namespace App\Providers;

use App\Services\FriendService;
use App\Services\MapperService;
use App\Services\MarathonService;
use App\Services\RecordService;
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

        $this->app->singleton(RecordService::class, function ($app) {
            return new RecordService($app->make(MapperService::class));
        });

        $this->app->singleton(MarathonService::class, function ($app) {
            return new MarathonService();
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
