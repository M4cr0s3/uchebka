<?php


use App\Http\Controllers\API\Auth\AuthController;

Route::group(['prefix' => 'auth'], function () {

    Route::get('me', [AuthController::class, 'me'])
        ->middleware('auth:api');
    Route::post('register', [AuthController::class, 'register'])
        ->name('register');
    Route::post('login', [AuthController::class, 'login'])
        ->name('login');
    Route::get('logout', [AuthController::class, 'logout'])
        ->name('logout')
        ->middleware('auth:api');
});
