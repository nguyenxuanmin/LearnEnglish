<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AdminService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AdminService::class, function ($app) {
            return new AdminService();
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
