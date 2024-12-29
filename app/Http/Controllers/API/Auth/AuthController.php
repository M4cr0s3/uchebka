<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\API\Auth\Input\LoginRequest;
use App\Http\Controllers\API\Auth\Input\RegisterRequest;
use App\Http\Controllers\API\Auth\Output\LoginResponse;
use App\Http\Controllers\API\Auth\Output\LogoutResponse;
use App\Http\Controllers\API\Auth\Output\RegisterResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cookie;

final readonly class AuthController
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        User::query()
            ->create($data);

        return RegisterResponse::make([
            'success' => true,
            'message' => 'Регистрация прошла успешно.',
        ]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (! $token = auth('api')->attempt($request->validated())) {
            return LoginResponse::make([
                'success' => false,
                'message' => 'Неверный логин или пароль.',
            ], 400);
        }

        return LoginResponse::make([
            'success' => true,
        ])->withCookie(Cookie::make(
            name: 'auth',
            value: $token,
            minutes: 60,
        ));
    }

    public function logout(): JsonResponse
    {
        \auth()->logout();
        Cookie::forget('auth');

        return LogoutResponse::make([
            'success' => true,
            'message' => 'Вы успешно вышли из системы.',
        ]);
    }

    public function me(): JsonResponse
    {
        return response()->json([
            'isAuth' => (bool) \auth()->user(),
            'role' => auth()->user()->role,
        ]);
    }
}
