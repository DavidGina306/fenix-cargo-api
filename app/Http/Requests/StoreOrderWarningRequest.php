<?php

namespace App\Http\Requests;

use App\Rules\MimeTypeRule;
use App\Traits\ValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderWarningRequest extends FormRequest
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
            'order_id' => 'required|uuid',
            'partner_id' => 'required|uuid',
            'profile' => ['required', Rule::in(['C', 'M', 'P'])],
            'value' => ['required', 'regex:/^\d{1,3}(\.\d{3})*,\d{2}$/'],
            'contact' => 'required_if:profile,M',
            'number' => 'required_if:profile,C,P',
            'files' => 'array|nullable',
            "files.*.file" => ['required_with:files', "required_with:files.*.ext"],
            "files.*.ext" => ['required_with:files', 'required_with:files.*.file',  new MimeTypeRule(['jpg', 'png', 'jpeg'])],
        ];
    }
}
