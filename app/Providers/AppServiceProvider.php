<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\UserProgress;
use App\Observers\UserProgressObserver;

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
    public function boot(): void
    {
        //
        UserProgress::observe(UserProgressObserver::class);
    }
}
