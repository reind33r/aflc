<?php

namespace App\Http\Controllers\Race;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Race\Team;

class MyTeamController extends Controller
{
    public function showOverview(Request $request) {
        $team = Team::where('captain_id', Auth::user()->id)
                    ->whereHas('registration_opportunity', function($q) use($request) {
                        $q->where('race_subdomain', $request->route('race')->subdomain);
                    })
                    ->first();

        return view('race.myteam.overview', [
            'team' => $team,
        ]);
    }
}