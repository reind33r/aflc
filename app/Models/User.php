<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'date',
    ];


    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return Str::ucfirst($this->first_name) . ' ' . Str::upper($this->last_name);
    }

    /**
     * Get teams
     */
    function teams() {
        return $this->hasMany('App\Models\Race\Team', 'captain_id');
    }

    /**
     * Get teams
     */
    function teams_as_pilot() {
        return $this->hasMany('App\Models\Race\TeamPilot');
    }

    /**
     * Get contact info
     */
    function contact_info() {
        return $this->belongsTo('App\Models\ContactInfo');
    }
}
