<?php

namespace App\Http\Controllers\Race;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class MyRegistrationController extends Controller
{
    public function showOverview(Request $request) {
        return view('race.myregistration.overview', [
        ]);
    }
}