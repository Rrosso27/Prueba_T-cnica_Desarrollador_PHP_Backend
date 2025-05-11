<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    /**
     * Register a new user and generate a JWT token.
     *
     * @param array $data
     * @return array{error: string|array{token: string, user: User}}
     */
    public function register(array $data)
    {
        try {
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->rol = $data['rol'];
            $user->password = Hash::make($data['password']);
            $user->save();
            $token = auth('api')->login($user);
            return ['token' => $token, 'user' => $user];
        } catch (\Exception $e) {
            return ['error' => 'Registration failed: ' . $e->getMessage()];
        }
    }
}
