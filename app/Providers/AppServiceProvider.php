<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();

        if (!app()->isLocal() && (request()->server('HTTP_X_FORWARDED_PROTO') === 'https' || app()->environment('production'))) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
