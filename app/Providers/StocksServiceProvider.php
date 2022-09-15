<?php

namespace App\Providers;

use App\Repositories\FinnhubRepository;
use App\Repositories\StocksRepository;
use Illuminate\Support\ServiceProvider;

class StocksServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(StocksRepository::class, function ($app) {
            return new FinnhubRepository();
        });
    }

    public function boot()
    {
        //
    }
}
