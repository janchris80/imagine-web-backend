<?php

namespace App\Services;

use App\Exceptions\TokenException;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    /**
     * Attempt to authenticate the user and generate a token.
     *
     * @throws TokenException
     */
    public function attemptLogin(array $credentials, bool $rememberMe = false): string
    {
        $token = Auth::attempt($credentials);

        if (! $token) {
            throw new TokenException('Invalid credentials', 401);
        }

        if ($rememberMe) {
            JWTAuth::factory()->setTTL(config('jwt.remember_me_ttl'));
        }

        return $token;
    }

    /**
     * Refresh the JWT token.
     *
     * @throws TokenException
     */
    public function refreshToken(): string
    {
        try {
            $token = Auth::refresh();
        } catch (\Exception $e) {
            throw new TokenException('Token refresh error', 401, $e);
        }

        if (! $token) {
            throw new TokenException('Token refresh error', 401);
        }

        return $token;
    }

    /**
     * Log out the user.
     */
    public function logout(): void
    {
        Auth::logout();
    }
}
