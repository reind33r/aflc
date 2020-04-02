<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\CMS\Page;
use App\Models\CMS\MenuItem;

class OrganizerController extends Controller
{
    public function overview(Request $request) {
        $pages = Page::where('race_subdomain', $request->route('race')->subdomain)
            ->orderBy('uri', 'asc')
            ->get();
        

        $menu_items = MenuItem::where('race_subdomain', $request->route('race')->subdomain)
            ->orderBy('order', 'asc')
            ->get();

        return view('cms.organizer.overview', [
            'pages' => $pages,
            'menu_items' => $menu_items,
        ]);
    }
}
