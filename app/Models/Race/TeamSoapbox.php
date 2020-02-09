<?php

namespace App\Models\Race;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TeamSoapbox extends Pivot {
    protected $fillable = ['team_id', 'soapbox_id'];

    // No created_at / updated_at columns
    public $timestamps = False;

    public function soapbox()
    {
        return $this->belongsTo('App\Models\Race\Soapbox', 'soapbox_id', 'id');
    }
}