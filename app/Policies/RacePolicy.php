<?php

namespace App\Policies;

use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Race\Race;
use App\Models\Race\Team;

class RacePolicy
{
    /**
     * Dealing with registrations:
     *  - is an user registered to a race (pilot / captain)
     *  - is an user pilot in a race
     *  - is an user captain in a race
     */

    public function captain(User $user, Race $race) {
        return Team::where('captain_id', $user->id)
                   ->where('race_subdomain', $race->subdomain)
                   ->exists();
    }

    public function register(?User $user, Race $race) {
        if(!$user) {
            return True;
        }

        return !$this->captain($user, $race);
    }


    // /**
    //  * Dealing with organization
    //  */

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
