<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidEmailDomain implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        list($user, $domain) = explode('@', $value);

        return checkdnsrr($domain, 'MX');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute domain is not a valid email domain.';
    }
}


