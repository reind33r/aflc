<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model {
    protected $table = 'cms_menu_item';

    /**
     * Get race
     */
    function race() {
        return $this->belongsTo('App\Models\Race\Race');
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
            return '/TODO';
        }
        else {
            return $this->external_link;
        }
    }

    /**
     * Returns a user-comprehensive link:
     * 1/ CMS Page: Page name [/{uri}]
     * 2/ Internal link: Route description [chemin interne]
     * 3/ External link: Lien externe [{external_link}]
     */
    public function getDisplayUrlAttribute($value) {
        if($this->cms_page_uri !== null) {
            $page = Page::where('race_subdomain', $this->race_subdomain)
                ->where('uri', $this->cms_page_uri)
                ->first('title');

            return $page['title'].' [/'.$this->cms_page_uri.']';
        } else if($this->internal_link !== null) {
            return 'À venir... [chemin interne]';
        } else {
            return 'Lien externe ['.$this->external_link.']';
        }
    }
}