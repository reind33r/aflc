<?php

namespace App\Models\Race;

use Illuminate\Database\Eloquent\Model;

class RegistrationOpportunity extends Model {
    public $timestamps = False;
    protected $dates = [
        'from',
        'to',
    ];

    /**
     * Get race
     */
    public function race() {
        return $this->belongsTo('App\Models\Race\Race');
    }

    /**
     * Get teams
     */
    public function teams() {
        return $this->hasMany('App\Models\Race\Team');
    }

    /**
     * Get pilots
     */
    public function pilots() {
        return $this->hasManyThrough('App\Models\Race\TeamPilot', 'App\Models\Race\Team');
    }

    /**
     * Get soapboxes
     */
    public function soapboxes() {
        return $this->hasManyThrough('App\Models\Race\TeamSoapbox', 'App\Models\Race\Team');
    }


    public function getIsTeamLimitReachedAttribute() {
        return ($this->team_limit !== null && $this->teams->count() >= $this->team_limit);
    }
    public function getIsTeamLimitAlmostReachedAttribute() {
        return ($this->team_limit !== null && $this->teams->count() >= 0.75 * $this->team_limit);
    }

    public function getIsPilotLimitReachedAttribute() {
        return ($this->pilot_limit !== null && $this->pilots->count() >= $this->pilot_limit);
    }
    public function getIsPilotLimitAlmostReachedAttribute() {
        return ($this->pilot_limit !== null && $this->pilots->count() >= 0.75 * $this->pilot_limit);
    }

    public function getIsSoapboxLimitReachedAttribute() {
        return ($this->soapbox_limit !== null && $this->soapboxes->count() >= $this->soapbox_limit);
    }
    public function getIsSoapboxLimitAlmostReachedAttribute() {
        return ($this->soapbox_limit !== null && $this->soapboxes->count() >= 0.75 * $this->soapbox_limit);
    }

    public function getIsLimitReachedAttribute() {
        return (
            $this->isTeamLimitReached ||
            $this->isPilotLimitReached ||
            $this->isSoapboxLimitReached
        );
    }

    public function getIsOpenAttribute() {
        return (
            ($this->from == null && $this->to == null) ||
            ($this->from == null && $this->to > now()) ||
            ($this->to == null && $this->from <= now()) ||
            ($this->from <= now() && $this->to > now())
        );
    }

    /**
     * Get team count
     */
    public function teamCount() {
        return $this->hasOne('App\Models\Race\Team')
                    ->selectRaw('registration_opportunity_id, COUNT(*) AS aggregate')
                    ->groupBy('registration_opportunity_id');
    }

    public function getTeamCountAttribute() {
        if (!$this->relationLoaded('teamCount')) {
            $this->load('teamCount');
        }

        $related = $this->getRelation('teamCount');

        // then return the count directly
        return ($related) ? (int) $related->aggregate : 0;
    }
}