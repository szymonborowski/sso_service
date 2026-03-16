<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExtendSessionForRememberMe
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get('remember_me')) {
            config(['session.lifetime' => 43200]); // 30 days
        }

        return $next($request);
    }
}
