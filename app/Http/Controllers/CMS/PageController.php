<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\CMS\PageRequest;

use App\Models\CMS\Page;

class PageController extends Controller
{
    public function show(Request $request) {
        $page = Page::where('uri', $request->route('uri', ''))
                    ->where('race_subdomain', $request->route('race')->subdomain)
                    ->first();
        
        if(!$page) {
            return view('cms.pages.404', [
                'uri' => $request->route('uri')
            ]);
        }

        return view('cms.pages.show', [
            'page' => $page,
        ]);
    }

    public function showEditForm(Request $request) {
        $page = Page::firstOrNew([
            'uri' => $request->route('uri', ''),
            'race_subdomain' => $request->route('race')->subdomain,
        ]);

        return view('cms.pages.edit', [
            'page' => $page,
        ]);
    }

    public function edit(PageRequest $request) {
        $validated = $request->validated();

        $page = Page::firstOrNew([
            'uri' => $request->route('uri', ''),
            'race_subdomain' => $request->route('race')->subdomain,
        ]);
        $page->content = $request->input('content');
        $page->title = $request->input('title');
        $page->save();

        flash('La page a été sauvegardée.')->success();
        return redirect()->route('cms.page', ['uri' => $page->uri]);
    }
}