<?php


namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait ValidationErrorTrait
{
    protected function failedValidation(Validator $validator)
    {
        $errors = [];
        foreach ($validator->errors()->toArray() as $key => $value) {
            $errors[$key] = $value[0];
        }

        throw new HttpResponseException(response()->json($errors, 422));
    }
}
