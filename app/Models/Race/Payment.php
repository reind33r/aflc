<?php

namespace App\Models\Race;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $timestamps = False;
    public $dates = [
        'payment_date',
    ];

    /**
     * Get team
     */
    function team() {
        return $this->belongsTo('App\Models\Race\Team');
    }
}
