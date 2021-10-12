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



Auth::routes();

Route::get('verify/{token}', '\App\Http\Controllers\Auth\RegisterController@verify')->name('account.verify');

Route::get('/rebuild', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    if(isset($_SERVER['HTTP_HOST'])){
        $root=(isset($_SERVER['HTTPS']) ? "https://" : "http://").$_SERVER['HTTP_HOST'];
        $root.= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        return "<script> window.location.href = '".$root."'; </script>";
    }
})->name('app.rebuild');

Route::group(['middleware' => ['SessionTimeout', 'XSS', 'auth']], function ($router) {

    Route::get('/', function () {
        $user = \Auth::user();
        if($user->can("view_dashboards")){
            return redirect()->route('dashboards.index');
        }else if($user->can("view_profiles")){
            return redirect()->route('profiles.index');
        }else{
            return abort(404);   
        }
    })->name("home");

    Route::get('/home', function () {
        return redirect()->route('home');
    });
       
    Route::resource('dashboards', '\App\Http\Controllers\DashboardController');

    Route::group(['prefix' => 'master'], function () {
        Route::resource('brands', '\App\Http\Controllers\BrandController');
        Route::resource('categories', '\App\Http\Controllers\CategoryController');
        Route::resource('customers', '\App\Http\Controllers\CustomerController');
        Route::resource('suppliers', '\App\Http\Controllers\SupplierController');
        Route::resource('types', '\App\Http\Controllers\TypeController');
        Route::resource('users', '\App\Http\Controllers\UserController');
        Route::resource('roles', '\App\Http\Controllers\RoleController');
        Route::resource('products', '\App\Http\Controllers\ProductController');
    });

    Route::group(['prefix' => 'transaction'], function () {
        Route::resource('sales', '\App\Http\Controllers\SaleController');
        Route::resource('purchases', '\App\Http\Controllers\PurchaseController');
    });

    Route::resource('reports', '\App\Http\Controllers\ReportController');
    Route::resource('profiles', '\App\Http\Controllers\ProfileController');

   

});


