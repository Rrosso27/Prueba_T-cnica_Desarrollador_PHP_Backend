<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle user login
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $response = $this->authService->login($credentials);

        if (isset($response['error'])) {
            return response()->json(['error' => $response['error']], 401);
        }

        return response()->json($response, 200);
    }

    /**
     * Summary of logout
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        return response()->json($this->authService->logout());
    }

    /**
     * Summary of me
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->authService->me());
    }
}
