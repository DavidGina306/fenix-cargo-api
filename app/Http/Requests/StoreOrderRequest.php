<?php

namespace App\Http\Requests;

use App\Traits\ValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreOrderRequest extends FormRequest
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
            'address_recipient' => array_merge(
                $this->address_recipient,
                [
                    'postcode' => preg_replace('/[^0-9]/', '', $this->address_recipient['postcode'])
                ]
            ),
            'payer' => array_merge(
                $this->payer,
                [
                    'postcode' => preg_replace('/[^0-9]/', '', $this->payer['postcode'])
                ]
            ),
            'address_sender' => array_merge(
                $this->address_sender,
                [
                    'postcode' => preg_replace('/[^0-9]/', '', $this->address_sender['postcode'])
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
            'material' => 'required|max:100',
            'total' => 'required',
            'barcode' => 'nullable|max:41',
            'quantity' => 'required',
            'height' => '',
            'width' => '',
            'length' => '',
            'weight' => 'required',
            'packing_type_id' => 'required|uuid',
            'doc_type_id' => 'required|uuid',
            'sender_id' => 'required_if:is_sender_id,false',
            'sender_name' => 'required_if:is_sender_id,true',
            'sender_search_for' => 'required|max:100',
            'phone_sender_search_for' => 'required|max:14',
            'address_sender' => 'array|required',
            'address_sender.address_line_1' => 'required|max:100',
            'address_sender.address_line_2' => 'required|max:100',
            'address_sender.address_line_3' => 'max:100',
            'address_sender.country' => 'required|max:50',
            'address_sender.town' => 'required|max:50',
            'address_sender.postcode' => 'required|min:8|max:8',
            'recipient_id' => 'required_if:is_recipient_id,false',
            'recipient_name' => 'required_if:is_recipient_id,true',
            'recipient_search_for' => 'required|max:100',
            'phone_recipient_search_for' => 'max:14',
            'address_recipient' => 'array|required',
            'address_recipient.address_line_1' => 'required|max:100',
            'address_recipient.address_line_2' => 'required|max:100',
            'address_recipient.address_line_3' => 'max:100',
            'address_recipient.country' => 'required|max:50',
            'address_recipient.town' => 'required|max:50',
            'address_recipient.postcode' => 'required|min:8|max:8',
            'payer' => 'array|required_if:is_payer,3',
            'payer.address_line_1' => 'required_if:is_payer,3|max:100',
            'payer.address_line_2' => 'required_if:is_payer,3|max:100',
            'payer.address_line_3' => 'max:100',
            'payer.country' => 'required_if:is_payer,3|max:50',
            'payer.town' => 'required_if:is_payer,3|max:50',
            'payer.postcode' => 'required_if:is_payer,3|min:8|max:8',
        ];
    }
}
