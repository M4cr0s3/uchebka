<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(
            User::query()
                ->where('role', '!=', 'ADMIN')
                ->get()
        );
    }

    public function update(User $user, Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'fio' => ['string'],
            'birthday' => ['date', 'before:' . Carbon::now()->format('Y-m-d H:i:s')],
            'passport' => ['string', 'digits:10'],
            'login' => ['unique:users', 'string'],
            'phone' => ['unique:users', 'string'],
            'email' => ['unique:users', 'email:rfc,dns'],
            'role' => [Rule::in(['USER', 'ADMIN'])],
        ]);

        $user->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Пользователь успешно обновлен'
        ]);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Пользователь успешно удален.'
        ]);
    }
}
