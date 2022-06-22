<?php

use App\Http\Controllers\city_controller;
use App\Http\Controllers\country_controller;
use App\Http\Controllers\index_js;
use App\Http\Controllers\region_controller;
use App\Http\Controllers\tb_crm_tr_sample_controller;
use App\Http\Controllers\tb_sys_mf_access_type_controller;
use App\Http\Controllers\tb_sys_mf_approval_hierarchy_type_controller;
use App\Http\Controllers\tb_sys_mf_config_controller;
use App\Http\Controllers\tb_sys_mf_mod_group_controller;
use App\Http\Controllers\tb_sys_mf_mod_controller;
use App\Http\Controllers\tb_sys_mf_status_controller;
use App\Http\Controllers\tb_sys_mf_user_controller;
use App\Http\Controllers\location_controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
})->middleware('auth');

// $gate = '';


// select

// SYS ROUTES RESOURCE
Route::resource('users', tb_sys_mf_user_controller::class);
Route::get('/users/edit-pw/{user}', 'App\Http\Controllers\tb_sys_mf_user_controller@edit_password')->name('users.edit-pw');
Route::put('/users/update-pw/{user}', 'App\Http\Controllers\tb_sys_mf_user_controller@update_password')->name('users.update-pw');

// DB::select * from sys-mdo
// for...
// $class = new $table;
// Route::resource($mod, $class)->middlewarehouse('can:has_access');

Route::resource('mods', tb_sys_mf_mod_controller::class)->middleware(["auth", "can:has_access,'MOD'"]);
Route::resource('mod-groups', tb_sys_mf_mod_group_controller::class)->middleware(["auth", "can:has_access,'MODG'"]);
Route::resource('access-types', tb_sys_mf_access_type_controller::class)->middleware(["auth", "can:has_access,'ACCESS'"]);
Route::resource('configs', tb_sys_mf_config_controller::class)->middleware(["auth", "can:has_access,'VAR'"]);
Route::resource('apr-types', tb_sys_mf_approval_hierarchy_type_controller::class)->middleware(["auth", "can:has_access,'APR'"]);
Route::resource('statuses', tb_sys_mf_status_controller::class)->middleware(["auth", "can:has_access,'STATUS'"]);


Route::post('dynamic-select', 'App\Http\Controllers\dynamic_select_controller@index')->name('dynamic-select');

Route::post('conditional-select', 'App\Http\Controllers\conditional_select_controller@index')->name('conditional-select');

Route::post('search', 'App\Http\Controllers\search_controller@index')->name('search');

Route::resource('countries', country_controller::class)->middleware(["auth", "can:has_access,'COUNTRY'"]);
Route::resource('regions', region_controller::class)->middleware(["auth", "can:has_access,'REGION'"]);
Route::resource('cities', city_controller::class)->middleware(["auth", "can:has_access,'CITY'"]);
Route::resource('locations', location_controller::class)->middleware(["auth", "can:has_access,'LOCATION'"]);

Route::resource('samples', tb_crm_tr_sample_controller::class)->middleware(["auth", "can:has_access,'SAMPLE'"]);




Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

