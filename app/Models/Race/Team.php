<?php

namespace App\Models\Race;

use Illuminate\Database\Eloquent\Model;

class Team extends Model {
    // Primay key following Laravel defaults
    // Automatic created_at / updated_at columns

    /**
     * Get race
     */
    function race() {
        return $this->belongsTo('App\Models\Race\Race', 'race_subdomain', 'subdomain');
    }

    /**
     * Get team captain
     */
    function captain() {
        return $this->belongsTo('App\Models\User', 'captain_id');
    }

    /**
     * Get all pilots for the team
     */
    public function pilots() {
        return $this->hasManyThrough('App\Models\Race\Pilot', 'App\Models\Race\RegistrationPilot');
    }

    /**
     * Get all soapboxes for the team
     */
    public function soapboxes() {
        return $this->hasManyThrough('App\Models\Race\Soapbox', 'App\Models\Race\RegistrationSoapbox');
    }
}