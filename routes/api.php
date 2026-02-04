<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\TripController;
use App\Http\Controllers\Api\Auth\DriverController;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [LoginController::class, 'submit']);

 Route::post('/login/verify', [LoginController::class, 'verify']);

 Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/driver', [DriverController::class, 'show']);
    Route::post('/driver', [DriverController::class, 'update']);

 Route::post('/trip', [TripController::class, 'store']);
 Route::get('/trip/{trip}', [TripController::class, 'show']);
 Route::post('/trip/{trip}/accept', ['TripController::class', 'accept']);
 Route::post('/trip/{trip}/start', ['TripController::class', 'start']);
 Route::post('/trip/{trip}/end', ['TripController::class', 'end']);
 Route::post('/trip/{trip}/location', ['TripController::class', 'location']);

    Route::get('/user', function(Request $request) {
        return $request->user();
    });
 });

