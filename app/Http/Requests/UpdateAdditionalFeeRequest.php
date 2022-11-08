<?php

namespace App\Http\Requests;

use App\Traits\ValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdditionalFeeRequest extends FormRequest
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
            'name' => 'required|unique:additional_fees,name,' . $this->doc,
            'value' => 'required'
        ];
    }
}
