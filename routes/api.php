<?php

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\AirlineController;
use App\Http\Controllers\FlightController;

Route::group(['prefix' => 'cities'], function (){
    Route::post('/', [CityController::class, 'store']);
    Route::delete('/{city}', [CityController::class, 'delete']);
    Route::put('/{city}', [CityController::class, 'update']);
});

Route::group(['prefix' => 'airlines'], function () {
    Route::post('/', [AirlineController::class, 'store']);
    Route::delete('/{airline}', [AirlineController::class, 'delete']);
    Route::put('/{airline}', [AirlineController::class, 'update']);
    Route::get('/', [AirlineController::class, 'all']);
});

Route::group(['prefix' => 'flights'], function () {
    Route::post('/', [FlightController::class, 'store']);
    Route::delete('/{flight}', [FlightController::class, 'delete']);
    Route::put('/{flight}', [FlightController::class, 'update']);
});

Route::group(['prefix' => 'flights'], function () {
    Route::post('/', [FlightController::class, 'store']); //me da error 404
    Route::delete('/{flight}', [FlightController::class, 'delete']);
    Route::put('/{flight}', [FlightController::class, 'update']);
});
