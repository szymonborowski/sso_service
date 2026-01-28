<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function () {
    $user = auth()->user();

    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'created_at' => $user->created_at,
    ]);
});
