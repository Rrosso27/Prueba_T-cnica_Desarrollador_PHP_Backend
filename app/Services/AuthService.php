<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Login and generate a JWT token.
     *
     * @param array $credentials
     * @return array{error: string|array{token: string, user: User}}
     */
    public function login(array $credentials)
    {
        try {
            // Intentar autenticar al usuario con el guard 'api'
            if (!$token = auth('api')->attempt($credentials)) {
                return ['error' => 'Invalid credentials'];
            }

            // Obtener el usuario autenticado
            $user = auth('api')->user();

            return ['user' => $user, 'token' => $token];
        } catch (\Exception $e) {
            return ['error' => 'Login failed: ' . $e->getMessage()];
        }
    }

    /**
     * Summary of logout
     * @return array{message: string}
     */
    public function logout()
    {
        try {
            Auth::user()->tokens()->delete();
            return ['message' => 'Logged out successfully'];
        } catch (\Exception $e) {
            return ['error' => 'Logout failed' . $e->getMessage()];
        }
    }
    /**
     * Summary of me
     * @return User
     */
    public function me()
    {
        try {
            return Auth::user();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized' . $e->getMessage()], 401);
        }
    }
}
