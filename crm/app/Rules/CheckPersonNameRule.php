<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckPersonNameRule implements Rule
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
    {//todo poprawic polksie znaki diakrytyczne bieze za blad
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
        return 'Imię i nazwisko może zawierać tylko litery alfabetu i pole nie może być puste';
    }
}
