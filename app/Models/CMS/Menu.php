<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {
    protected $table = 'cms_menu';

    /**
     * Get race
     */
    function race() {
        return $this->belongsTo('App\Models\Race\Race');
    }
}