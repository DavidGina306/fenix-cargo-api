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
            'partner_id' => 'uuid|nullable',
            'destiny_type' => 'required',
            'destiny_initial' => 'required',
            'destiny_final' => 'max:100|nullable',
            'destiny_state' => 'required',
            'origin_type' => 'required',
            'origin_initial' => 'required',
            'origin_state' => 'required',
            'deadline_type' => 'required',
            'deadline_initial' => 'required',
            'deadline_final' => 'required',
            'rule_types' => 'array|required',
            'rule_types.*.fee_rule_id' => 'required|uuid',
            'rule_types.*.currency_id' => 'uuid|nullable',
            'rule_types.*.value' => 'required',
            'rule_types.*.weight_initial' => 'required',
            'rule_types.*.weight_final' => 'nullable',

        ];
    }
}
