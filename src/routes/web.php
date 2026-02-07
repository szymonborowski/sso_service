<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// Kubernetes liveness probe - process is alive
Route::get('/health', function () {
    return response()->json(['status' => 'ok'], 200);
});

// Kubernetes readiness probe - DB is reachable
Route::get('/ready', function () {
    try {
        DB::connection()->getPdo();
        return response()->json(['status' => 'ready'], 200);
    } catch (\Throwable $e) {
        return response()->json(['status' => 'not ready', 'error' => $e->getMessage()], 503);
    }
});

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::match(['get', 'post'], '/logout', [LoginController::class, 'destroy'])->name('logout');
