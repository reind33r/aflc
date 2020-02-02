<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MobilePhone implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^0[67][ -.]?([0-9]{2}[ -.]?){4}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Le champ :attribute doit correspondre à un numéro de téléphone mobile français (par exemple : 06 78 90 12 34).';
    }
}
