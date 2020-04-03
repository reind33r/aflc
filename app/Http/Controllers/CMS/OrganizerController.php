<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use App\Models\CMS\Page;
use App\Models\CMS\MenuItem;

class OrganizerController extends Controller
{
    public function overview(Request $request) {
        $race = $request->route('race');

        $pages = Page::where('race_subdomain', $race->subdomain)
            ->orderBy('uri', 'asc')
            ->get();
        
        
        // Gallery
        $path = 'cms/space' . $race->organizer_id . '/images/';
        $images = Storage::files($path);

        return view('cms.organizer.overview', [
            'pages' => $pages,
            'images' => $images,
        ]);
    }
}
