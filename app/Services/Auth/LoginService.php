<?php

namespace App\Services\Auth;

use Exception;

class LoginService
{
    public function execute($credentials)
    {
        if (!$token = auth()->setTTL(24*60)->attempt($credentials))
        {
            throw new Exception('Not authorized', 401);
        }

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ];
    }
}
