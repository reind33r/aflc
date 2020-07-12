<?php

namespace App\Http\Requests\Race;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;
use App\Rules\MobilePhone;

use App\Models\Race\RegistrationOpportunity;

use Illuminate\Support\Facades\Auth;

class RegistrationRequest extends FormRequest
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
        $commonRules = [
            'step' => 'required|in:0,1,2,3,4,5'
        ];

        switch ($this->input('step')) {
            case 0:
                return $commonRules + [
                    'registration_opportunity_id' => 'required|exists:registration_opportunities,id'
                ];
                break;

            case 1:
                return $commonRules + [
                    'honorific_prefix' => 'required|in:m,mme,autre',
                    'first_name' => 'required|string|max:100',
                    'last_name' => 'required|string|max:100',
                    'email' => [
                        'required',
                        'email',
                        Rule::unique('users')->ignore(Auth::user())
                    ],
                    'mobile_phone' => ['required', new MobilePhone],
                    'address' => 'required|string',
                    'zip_code' => 'required|string|size:5',
                    'city' => 'required|string|max:100',
                ];
                break;

            case 2:
                return $commonRules + [
                    'captain_is_pilot' => 'boolean',
                    'captain_birthday' => 'required_with:captain_is_pilot|nullable|date',
                    'pilots' => 'array|required_unless:captain_is_pilot,1',
                    'pilots.*.honorific_prefix' => 'required|in:m,mme,autre',
                    'pilots.*.first_name' => 'required|string|max:100',
                    'pilots.*.last_name' => 'required|string|max:100',
                    'pilots.*.birthday' => 'required|date',
                ];
                break;

            case 3:
                return $commonRules + [
                    'soapboxes' => 'array|required',
                    'soapboxes.*.name' => 'required|string|max:25',
                    'soapboxes.*.desired_number' => 'nullable|digits:3',
                ];
                break;

            case 4:
                return $commonRules + [
                    'team_name' => 'required|string|max:30',
                    'captain_check' => 'accepted',
                    'pilots_check' => 'accepted',
                    'soapboxes_check' => 'accepted',
                    'payment_check' => 'accepted',
                    'rgpd_check' => 'accepted',
                ];
                break;
            
            default:
                return $commonRules;
                break;
        }
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if(!array_key_exists('step', $this->validated())) { return; }

            if($this->validated()['step'] == 0) {
                if(!array_key_exists('registration_opportunity_id', $this->validated())) { return; }

                $ro = RegistrationOpportunity::find($this->validated()['registration_opportunity_id']);
                
                if(!$ro->isOpen) {
                    $validator->errors()->add('registration_opportunity_id', 'La période d\'inscription est terminée.');
                }
                if($ro->isLimitReached && !$ro->soft_limits) {
                    $validator->errors()->add('registration_opportunity_id', 'La limite d\'inscriptions est déjà atteinte.');
                }
            }
        });
    }

    /**
     * Sets the redirect route on error according to the step we're validating
     */
    protected function getRedirectUrl()
    {
        if($this->input('step') == 0) {
            $this->redirectRoute = 'race.register';
        } else {
            $this->redirectRoute = 'race.register.step' . $this->input('step', 1);
        }

        return parent::getRedirectUrl();
    }
}
