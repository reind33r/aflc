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

Route::domain('root.'.env('APP_DOMAIN'))->group(function () {
    Auth::routes(['verify' => true]);
});

Route::domain('{race}.'.env('APP_DOMAIN'))->middleware('race_subdomain')->group(function () {    
    Route::get('/', function () {
        return view('cms.page');
    })->name('index');
});

// Route::get('/home', 'HomeController@index')->name('home');