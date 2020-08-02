<?php

namespace App\Http\Controllers\Race;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Race\Team;

class RegistrationOrganizerController extends Controller
{
    public function list(Request $request) {
        $teams = Team::whereHas('registration_opportunity', function($q) use($request) {
                                $q->where('race_subdomain', $request->route('race')->subdomain);
                            })
                            ->orderBy('created_at', 'asc')
                            ->get();
        
        return view('race.organizer.registrations.list', [
            'teams' => $teams,
        ]);
    }
}