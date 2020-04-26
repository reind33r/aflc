<?php

namespace App\Http\Requests\Race;

use Illuminate\Foundation\Http\FormRequest;

class RaceInfoRequest extends FormRequest
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
            'name' => 'required|string|max:30',
            'location' => 'required|string|max:30',
            'date' => 'required|date',
        ];
    }
}
