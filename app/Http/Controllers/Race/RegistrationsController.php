<?php

namespace App\Http\Controllers\Race;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Race\Team;

class RegistrationsController extends Controller
{
    public function showRegistrations(Request $request) {
        $pending_teams = Team::whereHas('registration_opportunity', function($q) use($request) {
                                $q->where('race_subdomain', $request->route('race')->subdomain);
                            })
                            ->get();
        
        return view('race.registrations', [
            'pending_teams' => $pending_teams,
        ]);
    }
}