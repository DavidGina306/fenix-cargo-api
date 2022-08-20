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
            'comment_1' => 'max:200|nullable',
            'comment_2' => 'max:200|nullable',
            'width' => 'required',
            'length' => 'required',
            'quantity' => 'required',
            'cubed_weight' => 'required',
            'doc_type_id' => 'required|uuid',
            'add_price' => 'required',
            'fee_type_id' => 'required|uuid'
        ];
    }
}
