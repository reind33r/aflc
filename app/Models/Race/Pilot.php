<?php

namespace App\Models\Race;

use Illuminate\Database\Eloquent\Model;

class Pilot extends Model {
    // Primary key follows Laravel defaults

    // No created_at / updated_at columns
    public $timestamps = False;

    /**
     * The teams that the pilot belongs to
     **/
    public function teams()
    {
        return $this->belongsToMany('App\Models\Race\Team')
                    ->using('App\Models\Race\RegistrationPilot');
    }
}