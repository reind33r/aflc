<?php

namespace App\Http\Controllers\Race;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\Race\RaceInfoRequest;
use App\Http\Requests\Race\EditRORequest;

use App\Models\Race\RegistrationOpportunity;

use Carbon\Carbon;

class OrganizerController extends Controller
{
    public function overview(Request $request) {
        return view('race.organizer.overview', [
        ]);
    }

    public function configuration(Request $request) {
        return view('race.organizer.configuration', [
        ]);
    }

    public function handleRaceInfo(RaceInfoRequest $request) {
        $validated = $request->validated();
        $race = $request->route('race');

        $race->name = $validated['name'];
        $race->location = $validated['location'];
        $race->date = $validated['date'];

        $race->save();

        flash('Les informations ont été mises à jour.')->success();
        return redirect()->route('race.organizer.configuration');
    }

    public function showEditROForm(Request $request) {
        $ro = RegistrationOpportunity::findOrFail($request->route('id'));

        return view('race.organizer.ro.edit', [
            'ro' => $ro,
        ]);
    }


    public function handleEditRO(EditRORequest $request) {
        $validated = $request->validated();
        $ro = RegistrationOpportunity::findOrFail($request->route('id'));

        $ro->description = $validated['description'];

        if($validated['from__date'] && $validated['from__time']) {
            $ro->from = Carbon::createFromFormat('Y-m-d H:i', $validated['from__date'] . ' ' . $validated['from__time']);
        } else {
            $ro->from = null;
        }
        if($validated['to__date'] && $validated['to__time']) {
            $ro->to = Carbon::createFromFormat('Y-m-d H:i', $validated['to__date'] . ' ' . $validated['to__time']);
        } else {
            $ro->to = null;
        }

        $ro->team_limit = $validated['team_limit'];
        $ro->pilot_limit = $validated['pilot_limit'];
        $ro->soapbox_limit = $validated['soapbox_limit'];

        $ro->teasing = $validated['teasing'] ?? False;
        $ro->soft_limits = $validated['soft_limits'] ?? False;

        if($ro->teamCount == 0) {
            $ro->fee_per_team = ceil($validated['fee_per_team'] * 100);
            $ro->fee_per_pilot = ceil($validated['fee_per_pilot'] * 100);
            $ro->fee_per_soapbox = ceil($validated['fee_per_soapbox'] * 100);
        }

        $ro->save();

        flash('Les informations ont été mises à jour.')->success();
        return redirect()->route('race.organizer.configuration');
    }

}