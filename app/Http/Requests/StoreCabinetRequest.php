<?php

namespace App\Http\Requests;

use App\Rules\MimeTypeRule;
use App\Traits\ValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreCabinetRequest extends FormRequest
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

    public function prepareForValidation()
    {
        $this->merge([
            'address' => array_merge(
                $this->address,
                [
                    'postcode' => preg_replace('/[^0-9]/', '', $this->address['postcode'])
                ]
            )
        ]);

        Log::warning($this->address);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => 'required|uuid',
            'address' => 'array|required',
            'address.address_line_1' => 'required|max:100',
            'address.address_line_2' => 'required|max:100',
            'address.address_line_3' => 'max:100',
            'address.country' => 'required|max:50',
            'address.town' => 'required|max:50',
            'address.postcode' => 'required|min:8|max:8',
            'productData' => 'array|required',
            'productData.*.quantity' => 'required',
            'productData.*.weight' => 'required',
            'productData.*.width' => 'required',
            'productData.*.height' => 'required',
            'productData.*.description' => 'required',
            'productData.*.locale_id' => 'required|uuid',
            'productData.*.length' => 'required',
            'productData.*.number' => 'required',
            'productData.*.position' => 'nullable',
            'productData.*.files' => 'array|required',
            "productData.*.files.*.file" => ['required_with:productData.*.files', "required_with:productData.*.files.*.ext"],
            "productData.*.files.*.ext" => ['required_with:productData.*.files', 'required_with:productData.*.files.*.file',  new MimeTypeRule(['jpg', 'png', 'jpeg'])],
        ];
    }
}
