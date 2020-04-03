<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\CMS\PageRequest;
use App\Http\Requests\CMS\DeletePageRequest;

use App\Models\CMS\Page;

class PageController extends Controller
{
    public function show(Request $request) {
        $race = $request->route('race');

        $page = Page::where('uri', $request->route('uri', ''))
                    ->where('race_subdomain', $race->subdomain)
                    ->first();
        
        if(!$page) {
            return view('cms.pages.404', [
                'uri' => $request->route('uri')
            ]);
        }

        if(
            (!Auth::guard('web:organizers')->user() || Auth::guard('web:organizers')->user()->cannot('organize', $race))
            
            &&

            (
                ($page->visibility == 'race_registered' && (!Auth::user() || Auth::user()->cannot('registered', $race)))
                ||
                ($page->visibility == 'race_not_registered' && (Auth::user() && Auth::user()->cannot('not_registered', $race)))
                ||
                ($page->visibility == 'race_organizer')
            )
        ) {            
            abort(403);
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
        $page->content = $validated['content'];
        $page->title = $validated['title'];
        $page->visibility = $validated['visibility'];
        $page->save();

        flash('La page a été sauvegardée.')->success();
        return redirect()->route('cms.page', ['uri' => $page->uri]);
    }

    public function showDeleteForm(Request $request) {
        $page = Page::where([
            'uri' => $request->route('uri', ''),
            'race_subdomain' => $request->route('race')->subdomain,
        ])->firstOrFail();

        return view('cms.pages.delete', [
            'page' => $page,
        ]);
    }

    public function delete(DeletePageRequest $request) {
        $validated = $request->validated();

        Page::where([
            'uri' => $validated['uri'],
            'race_subdomain' => $request->route('race')->subdomain,
        ])->delete();

        flash('La page a été supprimée.')->success();
        return redirect()->route('cms.organizer');
    }
}