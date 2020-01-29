<?php

namespace App\Http\Controllers\Race;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;

class RegistrationController extends Controller
{
    /**
     * Step 1: login
     */
    public function showStep1(Request $request) {
        // If login error, errors are shown in this page; if success, redirect to next step
        Session::put('previous_url', URL::current());

        return view('race.register.step1', [

        ]);
    }

    // https://www.5balloons.info/multi-page-step-form-in-laravel-with-validation/
}