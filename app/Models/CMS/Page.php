<?php

namespace App\Models\CMS;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;

class Page extends Model {
    protected $table = 'cms_pages';

    use \App\Traits\HasCompositePrimaryKey;
    protected $primaryKey = ['race_subdomain', 'uri'];
    // Automatic created_at / updated_at columns

    /**
     * Get race
     */
    function race() {
        return $this->belongsTo('App\Models\Race\Race');
    }



    /**
     * Get the Page's text as HTML
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function getContentAttribute($value)
    {
        // Hash the text with the lowest computational hasher available.
        $key = 'cms_page|'.$this->race_subdomain.'|'.$this->uri.'|'.hash('crc32', $value);

        return Cache::remember($key, 86400, function () use ($value) {
            return $this->parseMarkdownToHtml($value);
        });
    }
    
    /**
    * Get the Page's text as HTML
    *
    * @return \Illuminate\Support\HtmlString
    */
    protected function parseMarkdownToHtml(string $text)
    {
        return new HtmlString(app(\Parsedown::class)->text($text));
    }
}