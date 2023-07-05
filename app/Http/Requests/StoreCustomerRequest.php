<?php

namespace App\Http\Requests;

use App\Traits\ValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    use ValidationErrorTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'address' => array_merge(
                $this->address,
                [
                    'postcode' => preg_replace('/[^0-9]/', '', $this->address['postcode'])
                ]
            )
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:200',
            'document' => 'nullable|max:100',
            'document_2' => 'nullable|max:200',
            'role' => 'max:100',
            'type' => 'required|in:J,F',
            'gender' => 'nullable|in:Masculino,Outro,Feminino',
            'agents' => 'array|required',
            'agents.*.departament' => 'nullable|max:200',
            'agents.*.name' => 'required|max:200',
            'agents.*.email' => 'max:200|email|unique:users,email',
            'agents.*.contact' => 'required|max:50',
        ];
    }
}
