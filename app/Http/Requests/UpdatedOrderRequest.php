<?php

namespace App\Http\Requests;

use App\Rules\MimeTypeRule;
use App\Traits\ValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdatedOrderRequest extends FormRequest
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
            'status_id' => 'required|uuid',
            'order_id' => 'required|uuid',
            'entry_date' => 'required|date',
            'time' => 'required',
            'document_type' => 'required|max:1',
            'doc_received_for' => 'required|max:200',
            'city' => 'required',
            'received_for' => 'required|max:200',
            'files' => 'array|nullable',
            "files.*.file" => ['required_with:files', "required_with:files.*.ext"],
            "files.*.ext" => ['required_with:files', 'required_with:files.*.file',  new MimeTypeRule(['jpg', 'png', 'jpeg'])],
        ];
    }
}
