<?php

namespace App\Http\Requests\Race;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Race\PilotDocument;

class EditPDRequest extends FormRequest
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
        $pd = PilotDocument::where('id', $this->route('id'))
                            ->where('race_subdomain', $this->route('race')->subdomain)
                            ->firstOrFail();

        $rules = [
            'description' => 'required|string',
            'type' => 'required|in:template,auto_template,external',
            'template_file' => 'nullable|file|mimes:pdf',
            'auto_template' => 'string|required_if:type,auto_template',
        ];

        if($pd->type != 'template') {
            $rules['template_file'] .= '|required_if:type,template';
        }

        return $rules;
    }
}
