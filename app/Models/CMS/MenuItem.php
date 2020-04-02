<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model {
    public $timestamps = False;


    public static $internal_links = [
        'race.register' => [
            'route' => 'race.register',
            'visibility' => 'race_not_registered',
            'name' => 'Formulaire d\'inscription',
        ],

        'race.myteam' => [
            'route' => 'race.myteam',
            'visibility' => 'race_registered',
            'name' => 'Espace pour les participants',
        ],

        'race.organizer' => [
            'route' => 'race.organizer',
            'visibility' => 'race_organizer',
            'name' => 'Espace pour les organisateurs',
        ],

        'race.registrations' => [
            'route' => 'race.registrations',
            'visibility' => 'all',
            'name' => 'Suivi des inscriptions',
        ],
    ];

    protected $table = 'cms_menu_item';

    /**
     * Get race
     */
    public function race() {
        return $this->belongsTo('App\Models\Race\Race');
    }


    /**
     * Returns link visibility
     * 
     * 1/ Returns the page visibility if applicable
     * 2/ Otherwise, returns the internal link visibility if applicable
     * 2/ Otherwise, returns the attribute stored in DB
     */
    public function getVisibilityAttribute($value) {
        if($this->cms_page_uri !== null) {
            $page = Page::where('race_subdomain', $this->race_subdomain)
                ->where('uri', $this->cms_page_uri)
                ->first('visibility');

            return $page['visibility'];
        } else if($this->internal_link !== null) {
            return MenuItem::$internal_links[$this->internal_link]['visibility'];
        }
        else {
            return $value;
        }
    }

    /**
     * Returns the full link (with https://)
     * Priority order (if more than one field is filled):
     * 1/ CMS Page
     * 2/ Internal link
     * 3/ External link
     */
    public function getUrlAttribute($value) {
        if($this->cms_page_uri !== null) {
            return route('cms.page', ['race' => $this->race_subdomain, 'uri' => $this->cms_page_uri]);
        } else if($this->internal_link !== null) {
            return route(MenuItem::$internal_links[$this->internal_link]['route']);
        }
        else {
            return $this->external_link;
        }
    }

    /**
     * Returns a user-comprehensive name
     * 1/ CMS Page: Page name [/{uri}]
     * 2/ Internal link: Route description [chemin interne]
     * 3/ External link: [{external_link}]
     */
    public function getDisplayUrlAttribute($value) {
        if($this->cms_page_uri !== null) {
            $page = Page::where('race_subdomain', $this->race_subdomain)
                ->where('uri', $this->cms_page_uri)
                ->first('title');

            return $page['title'].' [/'.$this->cms_page_uri.']';
        } else if($this->internal_link !== null) {
            return MenuItem::$internal_links[$this->internal_link]['name'];// . ' ['. route(MenuItem::$internal_links[$this->internal_link]['route'], [], false) .']';
        } else {
            return '['.$this->external_link.']';
        }
    }
}