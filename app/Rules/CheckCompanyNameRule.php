<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckCompanyNameRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     *
     * php artisan make:rule CheckCompanyNameRule
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
        $pattern = "/^[A-Za-z]+$/";
        if (preg_match($pattern, $value) && !empty($value) ) {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Nazwa firmy może zawierac tylko litery alfabetu i pole nie może być puste';
    }
}
