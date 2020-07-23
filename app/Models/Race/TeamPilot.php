<?php

namespace App\Models\Race;

use Illuminate\Database\Eloquent\Relations\Pivot;

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
}