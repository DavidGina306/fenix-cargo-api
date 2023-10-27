<?php

namespace App\Http\Requests;

use App\Rules\MimeTypeRule;
use Illuminate\Foundation\Http\FormRequest;

class ObejctoToOrderRequest extends FormRequest
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
            'customer_id' => 'required|uuid',
            'address' => 'array|required',
            'address.address_line_1' => 'required|max:100',
            'address.address_line_2' => 'required|max:100',
            'address.address_line_3' => 'max:100',
            'address.country' => 'required|max:50',
            'address.town' => 'required|max:50',
            'address.postcode' => 'required|min:8|max:8',
            'items' => 'array|required',
            'items.*.description' => 'required',
            'items.*.measure' => 'required',
            'items.*.number' => 'required',
            'items.*.quantity' => 'required'
        ];
    }
}
