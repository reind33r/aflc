<?php

namespace App\Http\Requests\Race;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Race\RegistrationOpportunity;

class NewRORequest extends FormRequest
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
            'from__date' => 'nullable|date|required_with:from__time',
            'from__time' => 'nullable|date_format:H:i|required_with:from__date',
            'to__date' => 'nullable|date|required_with:to__time',
            'to__time' => 'nullable|date_format:H:i|required_with:to__date',
            'fee_per_team' => 'required|numeric',
            'fee_per_pilot' => 'required|numeric',
            'fee_per_soapbox' => 'required|numeric',
            'team_limit' => 'nullable|integer|min:0',
            'soapbox_limit' => 'nullable|integer|min:0',
            'pilot_limit' => 'nullable|integer|min:0',
            'teasing' => 'boolean',
            'soft_limits' => 'boolean',
        ];
    }
}
