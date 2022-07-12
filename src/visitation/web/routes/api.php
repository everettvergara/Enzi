<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::post('mobile-services/create', 'App\Http\Controllers\sync_controller_mobile_services@create');
// Route::get('mobile-services/retrieve-all-date-range', 'App\Http\Controllers\sync_controller_mobile_services@retrieve_all_date_range');
// Route::get('mobile-services/retrieve-user-date-range', 'App\Http\Controllers\sync_controller_mobile_services@retrieve_user_date_range');
// Route::get('mobile-services/retrieve-user-date', 'App\Http\Controllers\sync_controller_mobile_services@retrieve_user_date');





Route::post('v1/register', 'App\Http\Controllers\ApiAuthController@register');
Route::post('v1/login', 'App\Http\Controllers\ApiAuthController@login');

//add this middleware to ensure that every request is authenticated
Route::middleware('auth:api')->group(function(){
    Route::get('v1/user', 'App\Http\Controllers\ApiAuthController@authenticatedUserDetails');
    Route::get('v1/visitation/get_by_date_range', 'App\Http\Controllers\tb_wf_tr_visitation_controller@get_by_date_range');
    Route::get('v1/visitation/get', 'App\Http\Controllers\tb_wf_tr_visitation_controller@get');
    Route::get('v1/visitation/get_entry', 'App\Http\Controllers\tb_wf_tr_visitation_controller@get_entry');
    Route::post('v1/visitation/update_entry', 'App\Http\Controllers\tb_wf_tr_visitation_controller@update_entry');
});
