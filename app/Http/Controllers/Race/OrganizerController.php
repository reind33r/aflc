<?php

namespace App\Http\Controllers\Race;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    public function overview(Request $request) {
        return view('race.organizer.overview', [
        ]);
    }
}
