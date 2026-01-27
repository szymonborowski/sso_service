<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Laravel\Passport\Contracts\AuthorizationViewResponse as AuthorizationViewResponseContract;

class AuthorizationViewResponse implements AuthorizationViewResponseContract, Responsable
{
    protected array $parameters = [];

    public function withParameters(array $parameters = []): static
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function toResponse($request)
    {
        return response()->view('oauth.authorize', $this->parameters);
    }
}
