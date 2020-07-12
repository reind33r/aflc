<?php

namespace App\Models\Race;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;

class PilotDocument extends Model {
    public $timestamps = False;

    /**
     * Get race
     */
    public function race() {
        return $this->belongsTo('App\Models\Race\Race');
    }


    /**
     * Get link to download (if type == template)
     */
    public function getDownloadPathAttribute() {
        return 'race/space' . $this->race->organizer_id . '/pilot_documents/' . $this->template_url;
    }
}