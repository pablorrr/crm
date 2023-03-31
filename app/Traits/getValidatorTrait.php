<?php
namespace App\Traits;

use App\Http\Requests\CompanyFormRequest;
use App\Http\Requests\PersonFormRequest;
use App\Http\Requests\TaskFormRequest;
use Illuminate\Support\Facades\Validator;

trait getValidatorTrait{
//todo w prsyszlosci uzyc jednego z wzorcoww prijektowych ktroy przetwarza podbne do siebie metody w jedna!


    public function getCompanyValidator(CompanyFormRequest $CompanyFormRequest )
    {
        $messages = [
            'name.unique'=> 'nazwa firmy nie moze się powtarzac',
            'phone.required' => 'telefon ma miec 9 cyfr',
            'email.required' => 'zly format Email i nie moze sie powtarzac',
            'email.unique' => 'email nie moze się powtarzac',
        ];

        return Validator::make($CompanyFormRequest->all(), $CompanyFormRequest->rules(), $messages);

    }

    public function getPersonValidator(PersonFormRequest $PersonFormRequest )
    {

        $messages = [
            'name.unique'=> 'imię nie moze się powtarzac',
            'surname.unique'=> 'nazwisko nie może się powtarzac',
            'phone.required' => 'telefon ma miec 9 cyfr',
            'photo.mimes:jpeg,png,'=> 'zly format obrazka',
            'email.required' => 'zly format Email i nie moze sie powtarzac',
            'email.unique' => 'email nie moze się powtarzac',

        ];

        return Validator::make($PersonFormRequest->all(), $PersonFormRequest->rules(), $messages);

    }
}
