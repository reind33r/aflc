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

    // Other
    protected $dates = [
        'date',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'subdomain';
    }

    /**
     * Get organizer
     */
    public function organizer() {
        return $this->belongsTo('App\Models\Organizer');
    }

    /**
     * Get menu items
     */
    public function menuItems() {
        return $this->hasMany('App\Models\CMS\MenuItem', 'race_subdomain', 'subdomain')->orderBy('order', 'asc');
    }

    /**
     * Get registration opportunities
     */
    public function registration_opportunities() {
        return $this->hasMany('App\Models\Race\RegistrationOpportunity');
    }

    /**
     * Get registration opportunities to display
     */
    public function display_registration_opportunities() {
        return $this->registration_opportunities()
                    ->withCount('teams')
                    ->withCount('pilots')
                    ->withCount('soapboxes')
                    // Where open
                    ->where(function($q) {
                        $q->where(function($query) {
                            $query->where('from', '<=', now())
                                  ->where('to', '>', now());
                        })
                        ->orWhere(function($query) {
                            $query->where('from', '<=', now())
                                  ->whereNull('to');
                        })
                        ->orWhere(function($query) {
                            $query->where('to', '>', now())
                                  ->whereNull('from');
                        })
                        ->orWhere(function($query) {
                            $query->whereNull('to')
                                  ->whereNull('from');
                        });
                    })
                    // Or where teasing and not past
                    ->orWhere(function($q) {
                        $q->where('teasing', true)
                          ->where('from', '>', now());
                    });
    }



    /**
     * Get pilot documents
     */
    public function pilotDocuments() {
        return $this->hasMany('App\Models\Race\PilotDocument', 'race_subdomain', 'subdomain');
    }
}