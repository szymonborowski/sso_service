<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function show()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        if ($request->boolean('remember')) {
            $request->session()->put('remember_me', true);
        }

        return redirect()->intended('/');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $redirectUri = $request->input('redirect_uri');

        if ($redirectUri && $this->isAllowedRedirectUri($redirectUri)) {
            return redirect($redirectUri);
        }

        return redirect('/');
    }

    private function isAllowedRedirectUri(string $uri): bool
    {
        $allowedHosts = [
            'frontend.microservices.local',
            'blog.microservices.local',
            'admin.microservices.local',
        ];

        $host = parse_url($uri, PHP_URL_HOST);

        return $host && in_array($host, $allowedHosts);
    }
}
