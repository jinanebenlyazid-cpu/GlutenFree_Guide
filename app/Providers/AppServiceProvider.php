<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

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
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();

        if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https' || app()->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        } else {
            // Also force HTTPS if ngrok is detected
            if (str_contains(request()->getHost(), 'ngrok-free.app') || str_contains(request()->getHost(), 'loca.lt')) {
                \Illuminate\Support\Facades\URL::forceScheme('https');
            }
        }
        
        // As a fallback to ensure we fix the user's explicit issue immediately:
        \Illuminate\Support\Facades\URL::forceScheme('https');
    }
}
