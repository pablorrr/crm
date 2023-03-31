<?php

namespace App\Http\Requests;

use App\Rules\CheckCompanyNameRule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
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
            'name' => [ new CheckCompanyNameRule, 'max:25',],
            'email' => ['required', 'max:32', 'email:rfc,dns'],
            'phone' => ['required', 'digits:9'],
        ];
    }
}
