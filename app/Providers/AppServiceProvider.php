<?php

namespace App\Providers;

use App\Models\Service;
use App\Observers\ServiceObserver;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
        Service::observe(ServiceObserver::class);
        date_default_timezone_set('Asia/Kolkata'); // Set your desired default timezone

    }
}