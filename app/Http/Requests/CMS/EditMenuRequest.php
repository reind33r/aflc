<?php

namespace App\Http\Requests\CMS;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

use App\Models\CMS\MenuItem;
use App\Models\CMS\Page;

class EditMenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'item' => 'array|nullable',
            'remove_item_ids' => 'array|nullable',
            'remove_item_ids.*' => [
                'required',
                'integer',
                Rule::exists('cms_menu_item', 'id')->where(function($query) {
                    $query->where('race_subdomain', $this->route('race')->subdomain);
                })
            ],
            'item.*.id' => [
                Rule::exists('cms_menu_item')->where(function($query) {
                    $query->where('race_subdomain', $this->route('race')->subdomain);
                })
            ],
            'item.*.name' => 'required|string|max:25',
            'item.*.order' => 'required|integer|between:0,255',
            'item.*.cms_page_uri' => [
                'nullable',
                'string',
                Rule::exists('cms_pages', 'uri')->where(function($query) {
                    $query->where('race_subdomain', $this->route('race')->subdomain);
                }),
            ],
            'item.*.internal_link' => [
                'string',
                Rule::in(array_keys(MenuItem::$internal_links)),
            ],
            'item.*.external_link' => 'url',
            'item.*.visibility' => 'required_with:item.*.external_link|string|in:all,race_registered,race_not_registered,race_organizer',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            foreach($this->input('item') as $i => $item) {
                if(!array_key_exists('cms_page_uri', $item) &&
                    !array_key_exists('external_link', $item) &&
                    !array_key_exists('internal_link', $item)
                ) {
                    $validator->errors()->add('item.'.$i, 'Au moins une URL est requise : CMS, interne ou externe...');
                } else if(
                    array_key_exists('cms_page_uri', $item) &&
                    empty($item['cms_page_uri']) &&
                    !Page::where('race_subdomain', $this->route('race')->subdomain)->where('uri', '')->exists()
                ) {
                    $validator->errors()->add('item.'.$i, 'La page n\'existe pas.');
                }
            }
        });
    }
}
