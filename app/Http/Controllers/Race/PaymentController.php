<?php

namespace App\Http\Controllers\Race;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\Race\Team;

class PaymentController extends Controller
{
    public function showStep5(Request $request) {
        $team = Team::where('captain_id', Auth::user()->id)
                    ->whereHas('registration_opportunity', function($q) use($request) {
                        $q->where('race_subdomain', $request->route('race')->subdomain);
                    })
                    ->first();

        return view('race.register.step5', [
            'team' => $team,
        ]);
    }
}