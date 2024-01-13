<?php

namespace App\Http\Requests;

use App\Rules\CheckPersonNameRule;
use Illuminate\Foundation\Http\FormRequest;

class PersonFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {//https://www.nicesnippets.com/blog/laravel-9-custom-validation-rules-example
        return [
            'name' => ['unique:persons', new CheckPersonNameRule, 'max:25',],
            'surname' => ['unique:persons', new CheckPersonNameRule, 'max:25',],
            'email' => [ 'unique:persons', 'max:32', 'email:rfc,dns'],
            'phone' => [ 'digits:9'],
            'photo' => ['mimes:jpeg,png,jpg'],
           ];
    }
}
