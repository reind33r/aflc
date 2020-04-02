<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\CMS\EditMenuRequest;

use App\Models\CMS\MenuItem;
use App\Models\CMS\Page;

class MenuController extends Controller
{
    public function showEditForm(Request $request) {
        $menu_items = MenuItem::where('race_subdomain', $request->route('race')->subdomain)
            ->orderBy('order', 'asc')
            ->get();
        

        $pages = Page::where('race_subdomain', $request->route('race')->subdomain)
            ->orderBy('uri', 'asc')
            ->get();

        return view('cms.menu.edit', [
            'menu_items' => $menu_items,
            'pages' => $pages,
            'internal_pages' => MenuItem::$internal_links,
        ]);
    }

    public function edit(EditMenuRequest $request) {
        $validated = $request->validated();

        foreach($validated['remove_item_ids'] ?? [] as $id_to_remove) {
            MenuItem::find($id_to_remove)->delete();
        }

        foreach($validated['item'] as $item) {
            if(array_key_exists('id', $item)) {
                $menu_item = MenuItem::find($item['id']);
            } else {
                $menu_item = new MenuItem();
                $menu_item->race_subdomain = $request->route('race')->subdomain;
            }

            if(array_key_exists('cms_page_uri', $item)) {
                $menu_item->cms_page_uri = $item['cms_page_uri'] ?? '';
                $menu_item->internal_link = null;
                $menu_item->external_link = null;
                $menu_item->visibility = null;
            } else if(array_key_exists('internal_link', $item)) {
                $menu_item->internal_link = $item['internal_link'];
                $menu_item->cms_page_uri = null;
                $menu_item->external_link = null;
                $menu_item->visibility = null;
            } else {
                $menu_item->external_link = $item['external_link'];
                $menu_item->visibility = $item['visibility'];
                $menu_item->internal_link = null;
                $menu_item->cms_page_uri = null;
            }

            $menu_item->order = $item['order'];
            $menu_item->name = $item['name'];

            $menu_item->save();
        }

        flash('Les changements ont été sauvegardés.')->success();

        return response()->json([
            'status' => 'success',
            'redirect_to' => route('cms.organizer'),
        ]);
    }
}