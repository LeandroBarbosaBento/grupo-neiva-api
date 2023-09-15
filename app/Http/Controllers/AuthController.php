<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Auth\LoginService;
use Exception;

class AuthController extends Controller
{
    private $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }
    public function login(Request $request)
    {
        try {

            $request->validate([
                'email' => 'email|required',
                'password' => 'string|required',
            ]);

            $credentials = $request->only('email', 'password');
            $auth = $this->loginService->execute($credentials);

            return response()->json([$auth], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function logout()
    {
        try {
            auth()->logout(true);
            return response()->json([
                'message' => 'The user is no longer loged in.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function me()
    {
        try {
            return response()->json(auth()->user(), 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
