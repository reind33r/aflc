<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\CMS\Page;

class PageController extends Controller
{
    public function show(Request $request) {
        $page = Page::where('uri', $request->route('uri'))
                    ->where('race_subdomain', $request->route('race')->subdomain)
                    ->first();
        
        if(!$page) {
            abort(404);
        }

        return view('cms.pages.show', [
            'page' => $page,
        ]);
    }
}