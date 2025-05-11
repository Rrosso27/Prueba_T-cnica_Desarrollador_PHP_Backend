<?php

namespace App\Http\Controllers;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\RegisterRequest;
use App\Services\RegisterService;
use App\Models\User;
class RegisterController extends Controller
{

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }
    /**
     * Register a new user and generate a JWT token.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->only('name', 'email', 'password', 'rol');
            $response = $this->registerService->register($data);
            if (isset($response['error'])) {
                return response()->json(['error' => $response['error']], 422);
            }
            return response()->json($response, status: 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Registration failed: ' . $e->getMessage()], 422);
        }
    }
}
