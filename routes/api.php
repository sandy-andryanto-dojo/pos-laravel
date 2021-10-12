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

Route::group(['middleware' => ['api', 'XSS'], 'prefix' => 'auth'], function ($router) {
    Route::post('login', '\App\Http\Controllers\Api\AuthController@login');
    Route::post('logout', '\App\Http\Controllers\Api\AuthController@logout');
    Route::post('refresh', '\App\Http\Controllers\Api\AuthController@refresh');
    Route::post('me', '\App\Http\Controllers\Api\AuthController@me');
});

Route::group(['middleware' => ['jwt.auth', 'XSS']], function() {
    
    Route::post('datatable/{route}/{model}', '\App\Http\Controllers\Api\ManageController@datatable')->name("api.datatable");
    Route::post('products', '\App\Http\Controllers\Api\ManageController@getProduct')->name("api.product");
    Route::post('dashboards', '\App\Http\Controllers\Api\ManageController@getDashboard')->name("api.dashboard");
    Route::delete('remove/{model}/{id}', '\App\Http\Controllers\Api\ManageController@remove')->name("api.remove.data");
   
});