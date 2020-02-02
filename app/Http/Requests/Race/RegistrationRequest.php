<?php

namespace App\Http\Requests\Race;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\MobilePhone;

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
        $commonRules = ['step' => 'required|in:1,2,3,4'];

        switch ($this->input('step')) {
            case 1:
                return $commonRules + [
                    'honorific_prefix' => 'required|in:m,mme,autre',
                    'first_name' => 'required|string|max:100',
                    'last_name' => 'required|string|max:100',
                    'email' => 'required|email',
                    'mobile_phone' => ['required', new MobilePhone],
                    'address' => 'required|string',
                    'zip_code' => 'required|string|size:5',
                    'city' => 'required|string|max:100',
                ];
                break;

            case 2:
                return $commonRules + [
                    'captain_is_pilot' => 'in:on',
                    'captain_birthday' => 'required_with:captain_is_pilot|nullable|date',
                    'pilots' => 'array|required',
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
            
            default:
                return $commonRules;
                break;
        }
    }

    /**
     * Sets the redirect route on error according to the step we're validating
     */
    protected function getRedirectUrl()
    {
        $this->redirectRoute = 'race.register.step' . $this->input('step', 1);

        return parent::getRedirectUrl();
    }
}
