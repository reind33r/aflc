<?php

namespace App\Http\Controllers\Race;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Race\Team;

use App\Models\Race\PilotDocument;

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

    public function downloadPD(Request $request) {
        $pd = PilotDocument::where('id', $request->route('pilot_document_id'))
                            ->where('race_subdomain', $request->route('race')->subdomain)
                            ->firstOrFail();
        
        // TODO : customize selon pilote :)

        return Storage::download($pd->template_url, $pd->description.'.'.pathinfo($pd->template_url)['extension']);
    }
}