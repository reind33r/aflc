<?php

namespace App\Models\Race;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RegistrationPilot extends Pivot {
    protected $fillable = ['team_id', 'user_id'];

    // No created_at / updated_at columns
    public $timestamps = False;
}