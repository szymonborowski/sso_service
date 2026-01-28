<?php

namespace App\Auth;

use App\Models\ApiUser;
use App\Services\UsersApiService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class ApiUserProvider implements UserProvider
{
    public function __construct(
        private UsersApiService $usersApi
    ) {}

    public function retrieveById($identifier): ?Authenticatable
    {
        // For Passport token validation, we need to fetch user by ID
        // This requires adding a getUserById method to UsersApiService
        $userData = $this->usersApi->getUserById($identifier);

        if (!$userData) {
            return null;
        }

        return ApiUser::fromApiResponse($userData);
    }

    public function retrieveByToken($identifier, $token): ?Authenticatable
    {
        // Remember me tokens are not supported with API-based users
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token): void
    {
        // Remember me tokens are not supported with API-based users
    }

    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        if (!isset($credentials['email']) || !isset($credentials['password'])) {
            return null;
        }

        $userData = $this->usersApi->checkCredentials(
            $credentials['email'],
            $credentials['password']
        );

        if (!$userData) {
            return null;
        }

        $user = ApiUser::fromApiResponse($userData);
        $user->setPassword($credentials['password']);

        return $user;
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        // Credentials were already validated in retrieveByCredentials
        // via the Users API
        return true;
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false): void
    {
        // Password hashing is handled by Users service
    }
}
