<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UsersApiService
{
    private string $baseUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.users.url');
        $this->apiKey = config('services.users.api_key');
    }

    public function checkCredentials(string $email, string $password): ?array
    {
        $response = Http::withHeaders([
            'X-Internal-Api-Key' => $this->apiKey,
            'Accept' => 'application/json',
        ])->post("{$this->baseUrl}/api/internal/auth/check", [
            'email' => $email,
            'password' => $password,
        ]);

        if ($response->successful() && $response->json('authorized')) {
            return $response->json('user');
        }

        return null;
    }

    public function createUser(string $name, string $email, string $password): ?array
    {
        $response = Http::withHeaders([
            'X-Internal-Api-Key' => $this->apiKey,
            'Accept' => 'application/json',
        ])->post("{$this->baseUrl}/api/internal/users", [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    public function getUserById(int $id): ?array
    {
        $response = Http::withHeaders([
            'X-Internal-Api-Key' => $this->apiKey,
            'Accept' => 'application/json',
        ])->get("{$this->baseUrl}/api/internal/users/{$id}");

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
