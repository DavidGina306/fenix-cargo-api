<?php

namespace App\Http\Requests;

use App\Traits\ValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
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
            'ordem' => 'required|max:100',
            'nome' => 'required|max:240',
            'codigo' => 'required|max:50',
            'sigla3' => 'required|max:50',
            'sigla2' => 'required|max:50'
        ];
    }
}
