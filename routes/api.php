<?php

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\AirlineController;

Route::group(['prefix' => 'cities'], function (){
    Route::post('/', [CityController::class, 'store']);
    Route::delete('/{city}', [CityController::class, 'delete']);
    Route::put('/{city}', [CityController::class, 'update']);
});

Route::group(['prefix' => 'airlines'], function () {
    Route::post('/', [AirlineController::class, 'store']);
    Route::delete('/{airline}', [AirlineController::class, 'delete']);
    Route::put('/{airline}', [AirlineController::class, 'update']);
});
