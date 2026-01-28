<?php

namespace App\Http\Controllers;

use App\Services\UsersApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function __construct(
        private UsersApiService $usersApi
    ) {}

    public function show(Request $request)
    {
        if ($request->has('redirect_uri')) {
            $request->session()->put('register_redirect_uri', $request->input('redirect_uri'));
        }

        return view('register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $userData = $this->usersApi->createUser(
            $validated['name'],
            $validated['email'],
            $validated['password']
        );

        if (!$userData) {
            throw ValidationException::withMessages([
                'email' => 'Nie udało się utworzyć konta. Email może być już zajęty.',
            ]);
        }

        // Log in the newly created user via API
        Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        $redirectUri = $request->session()->pull('register_redirect_uri');

        if ($redirectUri) {
            return redirect($redirectUri)->with('status', 'Rejestracja zakończona pomyślnie!');
        }

        return redirect()->intended('/')->with('status', 'Rejestracja zakończona pomyślnie!');
    }
}
