<?php

namespace App\Http\Requests;

use App\Rules\MimeTypeRule;
use App\Traits\ValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderMovementRequest extends FormRequest
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
            'status_id' => 'required|uuid',
            'entry_date' => 'required|date',
            'doc_received_for'=> 'required',
            'received_for'=> 'required',
            'city' => 'required|in:O,D,M',
            'other_city' => 'required_if:city,M|max:100',
            'time' => 'required',
            'files' => 'array|nullable',
            "files.*.file" => ['required_with:files', "required_with:files.*.ext"],
            "files.*.ext" => ['required_with:files', 'required_with:files.*.file',  new MimeTypeRule(['jpg', 'png', 'jpeg'])],
        ];
    }
}
