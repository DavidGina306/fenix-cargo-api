<?php

namespace App\Http\Requests;

use App\Traits\ValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'name' => 'required|max:200',
            'document' => 'required|max:100',
            'role' => 'max:100',
            'type' => 'required',
            'gender' => 'nullable',
            'email' => 'required|max:200|email',
            'email_2' => 'email|nullable',
            'contact' => 'required|max:50',
            'contact_2' => 'max:100|nullable'
        ];
    }
}
