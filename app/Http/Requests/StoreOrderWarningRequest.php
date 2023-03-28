<?php

namespace App\Http\Requests;

use App\Rules\MimeTypeRule;
use App\Traits\ValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;

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
            'agent' => 'required',
            'value' => 'required',
            'note' => 'required',
            'responsible' => 'required|max:200',
            'files' => 'array|nullable',
            "files.*.file" => ['required_with:files', "required_with:files.*.ext"],
            "files.*.ext" => ['required_with:files', 'required_with:files.*.file',  new MimeTypeRule(['jpg', 'png', 'jpeg'])],
        ];
    }
}
