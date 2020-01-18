<?php

namespace App\Models\Race;

use Illuminate\Database\Eloquent\Model;

class Race extends Model {
    // Configuring Model primary key
    protected $primaryKey = 'subdomain';
    public $incrementing = False;
    protected $keyType = 'string';

    // No created_at / updated_at columns
    public $timestamps = False;

    /**
     * Get teams
     */
    function teams() {
        return $this->hasMany('App\Models\Race\Team', 'race_subdomain', 'subdomain');
    }
}