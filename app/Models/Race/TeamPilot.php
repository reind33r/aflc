<?php

namespace App\Models\Race;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TeamPilot extends Pivot {
    protected $fillable = ['team_id', 'user_id'];

    // No created_at / updated_at columns
    public $timestamps = False;

    public function pilot()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}