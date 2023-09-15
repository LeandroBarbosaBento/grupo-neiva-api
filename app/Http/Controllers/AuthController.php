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
        return response()->json(['status' => 'working logout']);
    }

    public function refresh()
    {
        return response()->json(['status' => 'working refresh']);
    }

    public function me()
    {
        return response()->json(['status' => 'working me']);
    }
}
