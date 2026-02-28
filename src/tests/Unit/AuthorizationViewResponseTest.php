<?php

namespace Tests\Unit;

use App\Http\Responses\AuthorizationViewResponse;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuthorizationViewResponseTest extends TestCase
{
    /** @return object{name: string, getKey: callable} */
    private function makeClientStub(string $name = 'Test Client', string $id = '1'): object
    {
        return new class($name, $id) {
            public function __construct(
                public readonly string $name,
                private readonly string $id
            ) {
            }

            public function getKey(): string
            {
                return $this->id;
            }
        };
    }

    /** @return list<object{description: string}> */
    private function makeScopesStub(): array
    {
        return [
            (object) ['description' => 'Read users'],
        ];
    }

    #[Test]
    public function with_parameters_returns_same_instance(): void
    {
        $response = new AuthorizationViewResponse();

        $result = $response->withParameters(['client' => $this->makeClientStub()]);

        $this->assertSame($response, $result);
    }

    #[Test]
    public function to_response_returns_200_and_renders_oauth_authorize_view(): void
    {
        $client = $this->makeClientStub('My App', '42');
        $scopes = $this->makeScopesStub();
        $request = Request::create('/oauth/authorize', 'GET', ['state' => 'abc123']);

        $response = new AuthorizationViewResponse();
        $response->withParameters([
            'client' => $client,
            'scopes' => $scopes,
            'request' => $request,
            'authToken' => 'token-xyz',
        ]);

        $httpResponse = $response->toResponse($request);

        $this->assertSame(200, $httpResponse->getStatusCode());
        $this->assertStringContainsString('My App', $httpResponse->getContent());
        $this->assertStringContainsString('oauth/authorize', $httpResponse->getContent());
    }

    #[Test]
    public function to_response_passes_parameters_to_view(): void
    {
        $client = $this->makeClientStub('Auth Client');
        $request = Request::create('/oauth/authorize');

        $response = new AuthorizationViewResponse();
        $response->withParameters([
            'client' => $client,
            'scopes' => [],
            'request' => $request,
            'authToken' => 'secret',
        ]);

        $httpResponse = $response->toResponse($request);

        $this->assertStringContainsString('Auth Client', $httpResponse->getContent());
    }
}
