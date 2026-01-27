<?php

namespace App\Providers;

use App\Http\Responses\AuthorizationViewResponse;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Laravel\Passport\Contracts\AuthorizationViewResponse as AuthorizationViewResponseContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AuthorizationViewResponseContract::class, AuthorizationViewResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        URL::forceScheme('https');
    }
}
