<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // API istəkləri üçün redirect yoxdur (JSON gözlənilir)
        if (! $request->expectsJson()) {
            return route('signin'); // veb üçün giriş səhifən varsa
        }
        return null;
    }
}
