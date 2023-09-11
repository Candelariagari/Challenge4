<?php

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['prefix' => 'cities'], function (){
    Route::post('/', [CityController::class, 'store']);
    Route::delete('/{city}', [CityController::class, 'delete']);
    Route::put('/{city}', [CityController::class, 'update']);
});
