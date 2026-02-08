<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config([
            'services.users.url' => 'http://users-nginx',
            'services.users.api_key' => 'test-api-key',
        ]);
    }

    #[Test]
    public function login_show_returns_200_and_view(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertViewIs('login');
    }

    #[Test]
    public function login_store_redirects_when_credentials_valid(): void
    {
        Http::fake([
            'users-nginx/api/internal/auth/check' => Http::response([
                'authorized' => true,
                'user' => [
                    'id' => 1,
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                    'created_at' => '2026-01-28T12:00:00.000000Z',
                ],
            ], 200),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }

    #[Test]
    public function login_store_returns_validation_error_when_credentials_invalid(): void
    {
        Http::fake([
            'users-nginx/api/internal/auth/check' => Http::response([
                'authorized' => false,
            ], 401),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrong',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    #[Test]
    public function logout_destroys_session_and_redirects(): void
    {
        Http::fake([
            'users-nginx/api/internal/auth/check' => Http::response([
                'authorized' => true,
                'user' => [
                    'id' => 1,
                    'name' => 'Test',
                    'email' => 'test@example.com',
                    'created_at' => now()->toISOString(),
                ],
            ], 200),
        ]);

        $this->post('/login', ['email' => 'test@example.com', 'password' => 'p']);
        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
