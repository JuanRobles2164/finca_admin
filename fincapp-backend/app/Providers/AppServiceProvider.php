<?php

namespace App\Providers;

use App\Repositories\Factory\RepositoryFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RepositoryFactory::class, function ($app) {
            return new RepositoryFactory();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
