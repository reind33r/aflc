<?php

namespace App\Models\Race;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

use App\Models\Race\TeamPilot;

class PilotDocument extends Model {
    public $timestamps = False;

    /**
     * Get race
     */
    public function race() {
        return $this->belongsTo('App\Models\Race\Race');
    }

    /**
     * Get team pilots
     */
    public function team_pilots() {
        return TeamPilot::join('m2m_pilot_documents', function($join) {
                        $join->on('team_pilot.user_id', '=', 'm2m_pilot_documents.user_id');
                        $join->on('team_pilot.team_id', '=', 'm2m_pilot_documents.team_id');
                    })
                    ->join('pilot_documents', 'm2m_pilot_documents.pilot_document_id', '=', 'pilot_documents.id');
    }
}