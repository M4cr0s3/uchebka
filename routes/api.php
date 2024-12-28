<?php

use App\Http\Controllers\API\AirportController;
use App\Http\Controllers\API\City\CityController;
use App\Http\Controllers\API\GeoController;
use Illuminate\Support\Facades\Route;

include __DIR__ . '/auth.php';

Route::group(['prefix' => 'geo'], function () {

    Route::get('/user', GeoController::class);

});

Route::group(['prefix' => 'cities'], function () {

    Route::get('/popular', [CityController::class, 'getMostPopular']);

    Route::group(['middleware' => 'auth:api'], function () {

        Route::get('/', [CityController::class, 'index']);
        Route::get('/{city}', [CityController::class, 'show']);
        Route::post('/', [CityController::class, 'store']);
        Route::patch('/{city}', [CityController::class, 'update']);
        Route::delete('/{city}', [CityController::class, 'destroy']);

    });

});

Route::group(['prefix' => 'airports'], function () {

    Route::group(['middleware' => 'auth:api'], function () {

        Route::get('/', [AirportController::class, 'index']);
        Route::get('/{airport}', [AirportController::class, 'show']);
        Route::post('/', [AirportController::class, 'store']);
        Route::patch('/{airport}', [AirportController::class, 'update']);
        Route::delete('/{airport}', [AirportController::class, 'destroy']);

    });

});

