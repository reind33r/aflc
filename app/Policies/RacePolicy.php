<?php

namespace App\Policies;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\User;
use App\Models\Organizer;
use App\Models\Race\Race;
use App\Models\Race\Team;
use App\Models\Race\TeamPilot;

class RacePolicy
{
    /**
     * Dealing with registrations:
     *  - is an user registered to a race (pilot / captain)
     *  - is an user pilot in a race
     *  - is an user captain in a race
     */

    public function captain(Authenticatable $user, Race $race) {
        if(!$user instanceof User) {
            return false;
        }

        return Team::where('captain_id', $user->id)
                   ->where('race_subdomain', $race->subdomain)
                   ->exists();
    }

    public function pilot(Authenticatable $user, Race $race) {
        if(!$user instanceof User) {
            return false;
        }

        return TeamPilot::where('user_id', $user->id)
                   ->whereHas('team', function($q) use($race) {
                       $q->where('race_subdomain', $race->subdomain);
                   })
                   ->exists();
    }

    public function registered(Authenticatable $user, Race $race) {
        return $this->captain($user, $race) || $this->pilot($user, $race);
    }

    public function register(?Authenticatable $user, Race $race) {
        if(!$user) {
            return True;
        }

        if(!$user instanceof User) {
            return false;
        }

        return !$this->registered($user, $race);
    }

    /**
     * Dealing with organization
     */

    public function organize(Authenticatable $organizer, Race $race) {
        if(!$organizer instanceof Organizer) {
            return false;
        }

        return ($race->organizer_id === $organizer->id);
    }

    // public function organize(User $user, Race $race) {
    //     return $user->admin or $this->_isUserOrganizer($user, $race);
    // }

    // private function _isUserOrganizer($user, $race) {
    //     $count = DB::table('m2m_races_organizers')
    //                ->whereRaceId($race->id)
    //                ->whereOrganizerUsername($user->username)
    //                ->count();
        
    //     return $count > 0;
    // }
}
