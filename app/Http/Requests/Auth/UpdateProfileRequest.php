<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\MobilePhone;

use Illuminate\Support\Facades\Auth;

class UpdateProfileRequest extends FormRequest
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
            'honorific_prefix' => 'required|in:m,mme,autre',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email',

            'birthday' => 'date|nullable',
            'mobile_phone' => ['nullable', new MobilePhone],
            'address' => 'nullable|string',
            'zip_code' => 'nullable|string|size:5',
            'city' => 'nullable|string|max:100',
        ];

        // Birthday required for pilots
        if(Auth::user()->teams_as_pilot()->count() > 0) {
            $rules['birthday'] = 'date|required';
        }

        // Contact info required for team captains
        if(Auth::user()->teams()->count() > 0) {
            $rules['mobile_phone'] = ['required', new MobilePhone];
            $rules['address'] = 'required|string';
            $rules['zip_code'] = 'required|string|size:5';
            $rules['city'] = 'required|string|max:100';
        }

        return $rules;
    }
}
