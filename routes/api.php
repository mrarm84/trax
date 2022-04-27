<?php

use Illuminate\Http\Request;
use Carbon\Carbon;
use \App\Http\Controllers\CarController;
use \App\Http\Controllers\TripController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


//////////////////////////////////////////////////////////////////////////
/// Mock Endpoints To Be Replaced With RESTful API.
/// - API implementation needs to return data in the format seen below.
/// - Post data will be in the format seen below.
/// - /resource/assets/traxAPI.js will have to be updated to align with
///   the API implementation
//////////////////////////////////////////////////////////////////////////

// Mock endpoint to get all cars for the logged in user



Route::get('/get-cars',  [CarController::class, 'index'])
->middleware('auth:api');


Route::get('/get-car/{car}', [CarController::class, 'show'])
    ->middleware('auth:api');


Route::post('add-car',   [CarController::class, 'store'])
    ->middleware('auth:api');

Route::delete('delete-car/{id}', [CarController::class, 'destroy'])
    ->middleware('auth:api');



Route::get('/get-trips',  [TripController::class, 'index'])

    ->middleware('auth:api');


Route::post('add-trip', [TripController::class, 'store'])
    ->middleware('auth:api');



