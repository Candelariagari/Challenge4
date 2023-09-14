<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\AirlineController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(['prefix' => 'cities'], function (){
    Route::get('/', [CityController::class, 'index']);
    Route::get('/{city}', [CityController::class, 'edit']);
});

Route::group(['prefix' => 'airlines'], function (){
    Route::get('/', [AirlineController::class, 'index']);
    Route::get('/{airline}',[AirlineController::class, 'edit']);
});
