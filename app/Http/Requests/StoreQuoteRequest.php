<?php

namespace App\Http\Requests;

use App\Traits\ValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuoteRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "fee_rule_id" => 'uuid|nullable',
            "customer_id" => 'uuid|nullable',
            "sender_name " => 'max:200|nullable',
            "sender_address_line_1" => 'max:150|nullable',
            "sender_address_line_2" => 'max:150|nullable',
            "sender_address_line_3" => 'max:150|nullable',
            "sender_address_states" => 'max:150|nullable',
            "sender_address_country" => 'max:150|nullable',
            "sender_address_town" => 'max:150|nullable',
            'sender_postcode' => 'max:8|nullable',
            'recieve_name' => 'max:200|nullable',
            'receive_postcode' => 'max:8|nullable',
            "receive_address_line_1" => 'max:150|nullable',
            "receive_address_line_2" => 'max:150|nullable',
            "receive_address_line_3" => 'max:150|nullable',
            "receive_address_states" => 'max:10|nullable',
            'receive_address_town' => 'max:100|nullable',
            "receive_address_country" => 'uuid|nullable',
            'doc_type_id' => 'required|uuid',
            'nf_price' => 'required',
            "productData" => 'array|required',
            "productData.*.quantity" => "nullable",
            "productData.*.height" => "nullable",
            "productData.*.width" => "nullable",
            "productData.*.length" => "nullable",
            "productData.*.weight" => "nullable",
            "productData.*.cubed_weight" => "nullable",
        ];
    }
}
