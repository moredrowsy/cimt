<?php

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

// index route
Route::get('/', 'PagesController@index');

// contains routes for login, registration, password reset, logout
Auth::routes(['verify' => true]);

// resource routes
Route::get('/resource/search', 'ResourceController@search')->name('resource.search');
Route::post('/resource/search', 'ResourceController@query')->name('resource.query');
Route::get('/resource/report', 'ResourceController@report')->name('resource.report');
Route::resource('/resource', 'ResourceController');

// incident routes
Route::get('/incident/search', 'IncidentController@search')->name('incident.search');
Route::post('/incident/search', 'IncidentController@query')->name('incident.query');
Route::get('/incident/report', 'IncidentController@report')->name('incident.report');
Route::resource('/incident', 'IncidentController');

// resource-incident request routes
Route::resource('/res-inc-requests', 'ResIncRequestController');
