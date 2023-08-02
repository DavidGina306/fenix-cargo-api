<?php

namespace App\Http\Requests;

use App\Traits\ValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreRelationPriceRequest extends FormRequest
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
            'partner_id' => 'nullable|uuid|required_if:type,P,C',
            'destiny_1' => 'required|max:100',
            'destiny_2' => 'required|max:100',
            'type' => 'required|in:C,P,F',
            'destiny_country' => 'nullable|uuid',
            'origin_country' => 'required|uuid',
            'deadline_type' => 'required',
            'deadline_initial' => 'required|integer|lte:deadline_final', // Usando "lte" (menor ou igual) para números inteiros
            'deadline_final' => 'required|integer',
            'rule_types' => 'array|required',
            'rule_types.*.fee_rule_id' => 'required|uuid',
            'rule_types.*.currency_id' => 'uuid|nullable',
            'rule_types.*.value' => 'required',
            'rule_types.*.weight_initial' => 'required',
            'rule_types.*.weight_final' => 'nullable',
        ];
    }
}
