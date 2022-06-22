<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('mobile-services/create', 'App\Http\Controllers\sync_controller_mobile_services@create');
Route::get('mobile-services/retrieve-all-date-range', 'App\Http\Controllers\sync_controller_mobile_services@retrieve_all_date_range');
Route::get('mobile-services/retrieve-user-date-range', 'App\Http\Controllers\sync_controller_mobile_services@retrieve_user_date_range');
Route::get('mobile-services/retrieve-user-date', 'App\Http\Controllers\sync_controller_mobile_services@retrieve_user_date');
