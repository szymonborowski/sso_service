# SSO Service (Single Sign-On)

OAuth 2.0 authorization server for the portfolio platform. Provides centralized authentication — login, registration, and token management — using Laravel Passport. All other services delegate authentication to SSO via the Authorization Code flow.

## Architecture

```
Frontend / Admin ──▶ SSO (Passport) ──▶ Users API (credential verification)
       ▲                  │
       └──────────────────┘
         (access token + redirect)
```

**Domain:** `sso.microservices.local`

## Tech Stack

- **Backend:** PHP 8.2 / Laravel 12
- **Auth server:** Laravel Passport 13.4 (OAuth 2.0)
- **Frontend:** Vite 7 (login/register views)
- **Database:** MySQL 8

## Auth Flows

### Authorization Code (used by Frontend and Admin)

1. Client redirects user to `GET /oauth/authorize`
2. User logs in at SSO (credentials verified via Users API)
3. SSO redirects back with authorization code
4. Client exchanges code for access token at `POST /oauth/token`

### Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/login` | Login form |
| POST | `/login` | Authenticate user |
| GET | `/register` | Registration form |
| POST | `/register` | Register new user |
| GET/POST | `/logout` | Logout user |
| GET | `/api/user` | Get authenticated user info (Bearer token) |
| GET | `/oauth/authorize` | OAuth authorization endpoint |
| POST | `/oauth/token` | Token endpoint |

### Health (Kubernetes probes)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/health` | Liveness probe |
| GET | `/ready` | Readiness probe (DB) |

## OAuth Clients

Registered OAuth clients (seeded):

| Client | Redirect URI |
|--------|-------------|
| Frontend | `frontend.microservices.local/auth/callback` |
| Admin | `admin.microservices.local/auth/sso/callback` |

## Getting Started

### Prerequisites

- Docker & Docker Compose
- Running infrastructure services (Traefik)
- Running Users service (for credential verification)

### Development

```bash
cp src/.env.example src/.env
# Edit .env with your configuration

docker compose up -d
```

Containers:

| Container | Role | Port |
|-----------|------|------|
| `sso-app` | PHP-FPM | 9000 (internal) |
| `sso-nginx` | Web server | via Traefik |
| `sso-vite` | Vite dev server (HMR) | 5173 |
| `sso-db` | MySQL 8 | 127.0.0.1:3306 |

### Running Tests

```bash
docker compose run --rm --no-deps \
  -e APP_ENV=testing -e DB_CONNECTION=sqlite -e DB_DATABASE=:memory: \
  sso-app ./vendor/bin/phpunit
```

## Test Coverage

| Metric | Value |
|--------|-------|
| Line coverage | 83.7% |
| Tests | 22 |

## Roadmap

- [x] OAuth 2.0 server (Laravel Passport)
- [x] Login and registration views
- [x] Integration with Users API for credential verification
- [x] OAuth client seeder (Frontend, Admin)
- [x] i18n translations
- [x] Kubernetes manifests and health endpoints
- [ ] Tests for AuthorizationViewResponse

## License

All rights reserved.
