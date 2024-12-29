<?php

use App\Http\Controllers\API\AirportController;
use App\Http\Controllers\API\City\CityController;
use App\Http\Controllers\API\Flight\FlightController;
use App\Http\Controllers\API\GeoController;
use App\Http\Controllers\API\PlaneController;
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


Route::group(['prefix' => 'planes'], function () {

    Route::group(['middleware' => 'auth:api'], function () {

        Route::get('/', [PlaneController::class, 'index']);
        Route::get('/{plane}', [PlaneController::class, 'show']);
        Route::post('/', [PlaneController::class, 'store']);
        Route::patch('/{plane}', [PlaneController::class, 'update']);
        Route::delete('/{plane}', [PlaneController::class, 'destroy']);

    });

});

Route::group(['prefix' => 'flights'], function () {

    Route::group(['middleware' => 'auth:api'], function () {

        Route::get('/', [FlightController::class, 'index']);
        Route::get('/{flight}', [FlightController::class, 'show']);
        Route::post('/', [FlightController::class, 'store']);
        Route::patch('/{flight}', [FlightController::class, 'update']);
        Route::delete('/{flight}', [FlightController::class, 'destroy']);

    });

});
