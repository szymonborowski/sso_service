<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
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
    public function register_show_returns_200_and_view(): void
    {
        $response = $this->get('/register');

        $response->assertOk();
        $response->assertViewIs('register');
    }

    #[Test]
    public function register_show_stores_redirect_uri_in_session(): void
    {
        $response = $this->get('/register?redirect_uri=https://frontend.microservices.local/callback');

        $response->assertOk();
        $this->assertEquals('https://frontend.microservices.local/callback', session('register_redirect_uri'));
    }

    #[Test]
    public function register_store_creates_user_and_redirects(): void
    {
        Http::fake([
            'users-nginx/api/internal/users' => Http::response([
                'data' => [
                    'id' => 1,
                    'name' => 'New User',
                    'email' => 'new@example.com',
                    'created_at' => now()->toISOString(),
                ],
            ], 201),
            'users-nginx/api/internal/auth/check' => Http::response([
                'authorized' => true,
                'user' => [
                    'id' => 1,
                    'name' => 'New User',
                    'email' => 'new@example.com',
                    'created_at' => now()->toISOString(),
                ],
            ], 200),
        ]);

        $response = $this->post('/register', [
            'name' => 'NewUser',
            'email' => 'new@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('status');
        $this->assertAuthenticated();
    }

    #[Test]
    public function register_store_returns_error_when_api_fails(): void
    {
        Http::fake([
            'users-nginx/api/internal/users' => Http::response(null, 422),
        ]);

        $response = $this->post('/register', [
            'name' => 'NewUser',
            'email' => 'existing@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
