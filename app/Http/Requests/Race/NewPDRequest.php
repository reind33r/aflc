<?php

namespace App\Http\Requests\Race;

use Illuminate\Foundation\Http\FormRequest;

class NewPDRequest extends FormRequest
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
            'description' => 'required|string',
            'type' => 'required|in:template,auto_template,external',
            'template_file' => 'nullable|file|mimes:pdf|required_if:type,template',
            'auto_template' => 'string|required_if:type,auto_template',
        ];
    }
}
