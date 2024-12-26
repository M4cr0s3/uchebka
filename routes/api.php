<?php

use App\Http\Controllers\API\City\CityController;
use App\Http\Controllers\API\GeoController;
use Illuminate\Support\Facades\Route;

include __DIR__ . '/auth.php';

Route::group(['prefix' => 'geo'], function () {

    Route::get('/user', GeoController::class);

});

Route::group(['prefix' => 'cities'], function () {

    Route::group(['middleware' => 'auth:api'], function () {

        Route::get('/', [CityController::class, 'index']);
        Route::post('/', [CityController::class, 'store']);
        Route::patch('/{city}', [CityController::class, 'update']);
        Route::delete('/{city}', [CityController::class, 'destroy']);

    });

    Route::get('/popular', [CityController::class, 'getMostPopular']);

});

