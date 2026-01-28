<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Passport\HasApiTokens;

class ApiUser implements Authenticatable
{
    use HasApiTokens;

    public int $id;
    public string $name;
    public string $email;
    public ?string $created_at;
    private ?string $password = null;
    private ?string $rememberToken = null;

    public function __construct(array $attributes = [])
    {
        $this->id = $attributes['id'] ?? 0;
        $this->name = $attributes['name'] ?? '';
        $this->email = $attributes['email'] ?? '';
        $this->created_at = $attributes['created_at'] ?? null;
    }

    public static function fromApiResponse(array $data): self
    {
        return new self([
            'id' => $data['id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'created_at' => $data['created_at'] ?? null,
        ]);
    }

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): mixed
    {
        return $this->id;
    }

    public function getAuthPasswordName(): string
    {
        return 'password';
    }

    public function getAuthPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    public function setRememberToken($value): void
    {
        $this->rememberToken = $value;
    }

    public function getRememberTokenName(): string
    {
        return 'remember_token';
    }
}
