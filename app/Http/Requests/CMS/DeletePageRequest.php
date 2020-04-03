<?php

namespace App\Http\Requests\CMS;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class DeletePageRequest extends FormRequest
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
        // dd($this->request->all());

        return [
            'confirm_delete' => 'required|in:on',
            'uri' => [
                'present',
                Rule::exists('cms_pages')->where(function($query) {
                    $query->where('race_subdomain', $this->route('race')->subdomain);
                })
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if($this->has('uri') && $this->get('uri') === null) {
            $this->merge([
                'uri' => '',
            ]);
        }
    }
}
