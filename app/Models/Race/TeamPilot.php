<?php

namespace App\Models\Race;

use Illuminate\Database\Eloquent\Relations\Pivot;

use Illuminate\Support\Facades\DB;
use App\Models\Race\PilotDocument;

class TeamPilot extends Pivot {
    use \App\Traits\HasCompositePrimaryKey;
    protected $primaryKey = ['team_id', 'user_id'];
    public $timestamps = False;

    protected $fillable = ['team_id', 'user_id'];

    public function pilot()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function team()
    {
        return $this->belongsTo('App\Models\Race\Team', 'team_id', 'id');
    }

    public function isDocumentValid(PilotDocument $pd) {
        return    DB::table('m2m_pilot_documents')
                    ->where('user_id', $this->user_id)
                    ->where('team_id', $this->team_id)
                    ->where('pilot_document_id', $pd->id)
                    ->where('valid', true)
                    ->exists();
    }

    public function allDocumentsValid() {
        $countReceived = DB::table('m2m_pilot_documents')
                            ->where('user_id', $this->user_id)
                            ->where('team_id', $this->team_id)
                            ->where('valid', true)
                            ->count();
        
        $countTotalDocuments = PilotDocument::where('race_subdomain', $this->team->registration_opportunity->race_subdomain)
                                            ->count();
        
        return ($countReceived == $countTotalDocuments);
    }
}