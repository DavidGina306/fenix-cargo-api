<?php

namespace App\Http\Requests;

use App\Traits\ValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UpdateMovementItemRequest extends FormRequest
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
        Log::info($this);
        return [
            'id' => 'required|uuid',
            'document_type' => 'required',
            'doc_received_for' => 'required',
            'received_for' => 'required'

        ];
    }
}
