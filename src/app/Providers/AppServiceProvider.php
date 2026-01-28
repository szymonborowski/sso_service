<?php

namespace App\Providers;

use App\Auth\ApiUserProvider;
use App\Http\Responses\AuthorizationViewResponse;
use App\Services\UsersApiService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
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

        Auth::provider('api_users', function ($app, array $config) {
            return new ApiUserProvider($app->make(UsersApiService::class));
        });
    }
}
