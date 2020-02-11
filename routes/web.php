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

    Route::get('/registrations', 'Race\RegistrationsController@showRegistrations')->name('race.registrations');

    Route::middleware('can:register,race')->group(function() {
        Route::post('/register/_handle', 'Race\RegistrationController@handleStep')->name('race.register.handleStep');
        Route::redirect('/register', '/register/1-captain')->name('race.register');
        Route::get('/register/1-captain', 'Race\RegistrationController@showStep1')->name('race.register.step1');
        Route::get('/register/2-pilots', 'Race\RegistrationController@showStep2')->name('race.register.step2');
        Route::get('/register/3-soapboxes', 'Race\RegistrationController@showStep3')->name('race.register.step3');
        Route::get('/register/4-team_overview', 'Race\RegistrationController@showStep4')->name('race.register.step4');
        Route::get('/register/5-payment', 'Race\RegistrationController@showStep5')->name('race.register.step5');
    });

    Route::middleware('can:captain,race')->group(function() {
        Route::get('/my_team', 'Race\MyTeamController@showOverview')->name('race.myteam');
    });
});

// Route::get('/home', 'HomeController@index')->name('home');