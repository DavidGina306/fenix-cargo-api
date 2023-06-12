<?php

namespace App\Http\Requests;

use App\Traits\ValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'payer' => array_merge(
                $this->payer,
                [
                    'postcode' => preg_replace('/[^0-9]/', '', $this->payer['postcode'])
                ]
            ),
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
            'payer' => 'array',
            'payer.id' => 'required|uuid',
            'payer.address_line_1' => 'required_if:is_payer,3|max:100',
            'payer.address_line_2' => 'required_if:is_payer,3|max:100',
            'payer.address_line_3' => 'max:100',
            'payer.country' => 'required_if:is_payer,3|max:50',
            'payer.town' => 'required_if:is_payer,3|max:50',
            'payer.postcode' => 'required_if:is_payer,3|min:8|max:8',
            'payment_type_id' => 'uuid|required',
            'interest' => 'required',
            'penalty' => 'required',
            'discount' => 'required',
            'value' => 'required',
            'quantity' => 'required',
            'due_date' => 'date',
            'bank_id' => 'uuid|required',
            'barcode' => 'max:200',
      ];
    }
}
