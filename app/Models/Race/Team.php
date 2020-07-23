<?php

namespace App\Models\Race;

use Illuminate\Support\HtmlString;

use Illuminate\Database\Eloquent\Model;

class Team extends Model {
    // Primay key following Laravel defaults
    // Automatic created_at / updated_at columns

    /**
     * Get race
     */
    function registration_opportunity() {
        return $this->belongsTo('App\Models\Race\RegistrationOpportunity');
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
    public function team_pilots() {
        return $this->hasMany('App\Models\Race\TeamPilot');
    }

    /**
     * Get all soapboxes for the team
     */
    public function team_soapboxes() {
        return $this->hasMany('App\Models\Race\TeamSoapbox');
    }


    /**
     * Get all payments for the team
     */
    public function payments() {
        return $this->hasMany('App\Models\Race\Payment');
    }

    public function getHtmlTeamCommentsAttribute() {
        if(empty($this->team_comments)) {
            return null;
        }

        return new HtmlString(nl2br(e($this->team_comments)));
    }

    public function getHtmlOrganizerCommentsAttribute() {
        if(empty($this->organizer_comments)) {
            return null;
        }

        return new HtmlString(nl2br(e($this->organizer_comments)));
    }

    /**
     * refused
     * validated
     * pending
     */
    public function getStatusAttribute() {
        if($this->refused) {
            return 'refused';
        }

        if($this->validated) {
            $unvalidated_flag = false;

            foreach($this->team_pilots()->get() as $team_pilot) {
                if(!$team_pilot->validated) {
                    $unvalidated_flag = true;
                    break;
                }
            }
            foreach($this->team_soapboxes()->get() as $team_soapbox) {
                if(!$team_soapbox->validated) {
                    $unvalidated_flag = true;
                    break;
                }
            }

            if($unvalidated_flag === false) {
                return 'validated';
            }
        }

        return 'pending';
    }

    public function getIsCompleteAttribute() {
        return False;
    }




    /**
     * Get pilot count
     */
    public function pilotCount() {
        return $this->hasOne('App\Models\Race\TeamPilot')
                    ->selectRaw('team_id, COUNT(*) AS aggregate')
                    ->groupBy('team_id');
    }

    public function getPilotCountAttribute() {
        if (!$this->relationLoaded('pilotCount')) {
            $this->load('pilotCount');
        }

        $related = $this->getRelation('pilotCount');

        // then return the count directly
        return ($related) ? (int) $related->aggregate : 0;
    }

    /**
     * Get soapbox count
     */
    public function soapboxCount() {
        return $this->hasOne('App\Models\Race\TeamSoapbox')
                    ->selectRaw('team_id, COUNT(*) AS aggregate')
                    ->groupBy('team_id');
    }

    public function getSoapboxCountAttribute() {
        if (!$this->relationLoaded('soapboxCount')) {
            $this->load('soapboxCount');
        }

        $related = $this->getRelation('soapboxCount');

        // then return the count directly
        return ($related) ? (int) $related->aggregate : 0;
    }


    /**
     * Payment-related
     */
    public function getTotalFeeAttribute() {
        return ($this->registration_opportunity->fee_per_team +
                $this->pilotCount * $this->registration_opportunity->fee_per_pilot +
                $this->soapboxCount * $this->registration_opportunity->fee_per_soapbox);
    }
}