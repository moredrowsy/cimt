<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('role', 'RoleController');
Route::resource('category', 'CategoryController');
Route::resource('func', 'FuncController');
Route::resource('unit-cost', 'UnitCostController');
Route::get('resource', 'ResourceController@list')->name('resource.list');
Route::get('resource/{id}', 'ResourceController@list_one')->name('resource.list-one');
Route::get('incident', 'IncidentController@list')->name('incident.list');
Route::get('incident/{id}', 'IncidentController@list_one')->name('incident.list-one');
