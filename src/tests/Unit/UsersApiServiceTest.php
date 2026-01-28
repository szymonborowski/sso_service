<?php

namespace Tests\Unit;

use App\Services\UsersApiService;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UsersApiServiceTest extends TestCase
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
    public function check_credentials_returns_user_data_on_success(): void
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

        $service = new UsersApiService();
        $result = $service->checkCredentials('test@example.com', 'password');

        $this->assertNotNull($result);
        $this->assertEquals(1, $result['id']);
        $this->assertEquals('test@example.com', $result['email']);

        Http::assertSent(function ($request) {
            return $request->hasHeader('X-Internal-Api-Key', 'test-api-key')
                && $request['email'] === 'test@example.com'
                && $request['password'] === 'password';
        });
    }

    #[Test]
    public function check_credentials_returns_null_on_invalid_credentials(): void
    {
        Http::fake([
            'users-nginx/api/internal/auth/check' => Http::response([
                'authorized' => false,
                'message' => 'Invalid credentials',
            ], 401),
        ]);

        $service = new UsersApiService();
        $result = $service->checkCredentials('test@example.com', 'wrong-password');

        $this->assertNull($result);
    }

    #[Test]
    public function create_user_returns_user_data_on_success(): void
    {
        Http::fake([
            'users-nginx/api/internal/users' => Http::response([
                'id' => 1,
                'name' => 'New User',
                'email' => 'newuser@example.com',
                'created_at' => '2026-01-28T12:00:00.000000Z',
            ], 201),
        ]);

        $service = new UsersApiService();
        $result = $service->createUser('New User', 'newuser@example.com', 'password123');

        $this->assertNotNull($result);
        $this->assertEquals('newuser@example.com', $result['email']);
    }

    #[Test]
    public function create_user_returns_null_on_failure(): void
    {
        Http::fake([
            'users-nginx/api/internal/users' => Http::response([
                'message' => 'The email has already been taken.',
            ], 422),
        ]);

        $service = new UsersApiService();
        $result = $service->createUser('New User', 'existing@example.com', 'password123');

        $this->assertNull($result);
    }

    #[Test]
    public function get_user_by_id_returns_user_data(): void
    {
        Http::fake([
            'users-nginx/api/internal/users/1' => Http::response([
                'id' => 1,
                'name' => 'Test User',
                'email' => 'test@example.com',
                'created_at' => '2026-01-28T12:00:00.000000Z',
            ], 200),
        ]);

        $service = new UsersApiService();
        $result = $service->getUserById(1);

        $this->assertNotNull($result);
        $this->assertEquals(1, $result['id']);
    }

    #[Test]
    public function get_user_by_id_returns_null_for_nonexistent_user(): void
    {
        Http::fake([
            'users-nginx/api/internal/users/999' => Http::response([
                'message' => 'User not found',
            ], 404),
        ]);

        $service = new UsersApiService();
        $result = $service->getUserById(999);

        $this->assertNull($result);
    }
}
