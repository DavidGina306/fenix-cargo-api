<?php

namespace App\Http\Requests;

use App\Traits\ValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdatePartnerRequest extends FormRequest
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
            'document' => 'required|max:100',
            'role' => 'max:100',
            'type' => 'required',
            'gender' => 'nullable',
            'agents' => 'array|required',
            'agents.*.name' => 'required|max:100',
            'agents.*.email' => 'max:200|email',
            'agents.*.contact' => 'required|max:50',
            'agents.*.departament' => 'required|max:50',
            'agents.*.id' => 'uuid|nullable',
            'address' => 'array|required',
            'address.address_line_1' => 'required|max:100',
            'address.address_line_2' => 'max:100',
            'address.address_line_3' => 'max:100',
            'address.country' => 'required|max:50',
            'address.town' => 'required|max:50',
            'address.postcode' => 'required|min:8|max:8',
        ];
    }
}
