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

Route::domain(env('APP_DOMAIN'))->group(function () {
    Route::get('/', 'HomeController@home')->name('home');

    Auth::routes(['verify' => true]);

    Route::get('/login/organizer', 'Auth\LoginController@showOrganizerLoginForm')->name('login:organizer');

    Route::middleware('auth')->get('/update_profile', 'Auth\UpdateProfileController@showForm')->name('auth.update_profile');
    Route::middleware('auth')->post('/update_profile', 'Auth\UpdateProfileController@handleForm');

    Route::get('/_closing', function() {
        return view('close_popup');
    })->name('close_popup');
});

Route::domain('{race}.'.env('APP_DOMAIN'))->middleware('race_subdomain')->group(function () {
    // Registration
    Route::prefix('/register')->middleware('can:register,race')->group(function() {
        Route::post('/_handle', 'Race\RegistrationController@handleStep')->name('race.register.handleStep');
        Route::redirect('', '/register/1-captain')->name('race.register');
        Route::get('/1-captain', 'Race\RegistrationController@showStep1')->name('race.register.step1');
        Route::get('/2-pilots', 'Race\RegistrationController@showStep2')->name('race.register.step2');
        Route::get('/3-soapboxes', 'Race\RegistrationController@showStep3')->name('race.register.step3');
        Route::get('/4-team_overview', 'Race\RegistrationController@showStep4')->name('race.register.step4');
        Route::get('/5-payment', 'Race\RegistrationController@showStep5')->name('race.register.step5');
    });

    // Registered users
    Route::middleware('can:captain,race')->group(function() {
        Route::get('/my_team', 'Race\MyTeamController@showOverview')->name('race.myteam');
    });

    // Organizer
    Route::prefix('/organizer')->middleware('use_organizer_guard', 'can:organize,race')->group(function() {
        Route::get('/', 'Race\OrganizerController@overview')->name('race.organizer');

        // CMS
        Route::prefix('/cms')->middleware('use_organizer_guard', 'can:organize,race')->group(function() {
            Route::get('/', 'CMS\OrganizerController@overview')->name('cms.organizer');

            Route::get('/menu', 'CMS\MenuController@showEditForm')->name('cms.menu.edit');
            Route::post('/menu', 'CMS\MenuController@edit')->name('cms.menu.edit');

            Route::post('/page/delete', 'CMS\PageController@delete')->name('cms.page.deleteAction');
            Route::get('/page/_delete/{uri?}', 'CMS\PageController@showDeleteForm')->name('cms.page.delete');

            Route::get('/page/{uri?}', 'CMS\PageController@showEditForm')->name('cms.page.edit'); // Needs to be last in subgroup!
            Route::post('/page/{uri?}', 'CMS\PageController@edit')->name('cms.page.edit'); // Needs to be last in subgroup!
        });
    });

    // Site pages
    Route::get('/registrations', 'Race\RegistrationsController@showRegistrations')->name('race.registrations');

    Route::get('{uri?}', 'CMS\PageController@show')->name('cms.page'); // Needs to be last!
});
