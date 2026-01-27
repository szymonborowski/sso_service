<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    protected array $policies = [];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Passport::tokensCan([
            'users.read' => 'Read users',
            'users.write' => 'Modify users',
        ]);
    }
}
