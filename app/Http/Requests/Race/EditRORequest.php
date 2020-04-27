<?php

namespace App\Http\Requests\Race;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Race\RegistrationOpportunity;

class EditRORequest extends FormRequest
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
        $rules = [
            'description' => 'required|string',
            'from__date' => 'nullable|date|required_with:from__time',
            'from__time' => 'nullable|date_format:H:i|required_with:from__date',
            'to__date' => 'nullable|date|required_with:to__time',
            'to__time' => 'nullable|date_format:H:i|required_with:to__date',
            'comment_on_payment' => 'nullable|string',
            'team_limit' => 'nullable|integer|min:0',
            'soapbox_limit' => 'nullable|integer|min:0',
            'pilot_limit' => 'nullable|integer|min:0',
            'teasing' => 'boolean',
            'soft_limits' => 'boolean',
        ];

        $ro = RegistrationOpportunity::findOrFail($this->route('id'));
        if($ro->teamCount == 0) {
            $rules += [
                'fee_per_team' => 'required|numeric',
                'fee_per_pilot' => 'required|numeric',
                'fee_per_soapbox' => 'required|numeric',
            ];
        }

        return $rules;
    }
}
