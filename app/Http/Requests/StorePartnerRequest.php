<?php

namespace App\Http\Requests;

use App\Traits\ValidationErrorTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StorePartnerRequest extends FormRequest
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
            'type' => 'required|in:J,F',
            'profile' => 'required|in:P,M,C',
            'gender' => 'nullable|in:Masculino,Outro,Feminino',
            'address' => 'array|required',
            'address.address_line_1' => 'required|max:100',
            'address.address_line_2' => 'max:100',
            'address.address_line_3' => 'max:100',
            'address.country' => 'required|max:50',
            'address.town' => 'max:50',
            'address.postcode' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($this->input('address.country') === 'Brasil') {
                        if (!preg_match('/^\d{8}$/', $value)) {
                            $fail('O campo CEP deve conter 8 dígitos numéricos.');
                        }
                    }
                },
            ],
            'agents' => 'array|required',
            'agents.*.name' => 'required|max:100',
            'agents.*.email' => 'max:200|email',
            'agents.*.contact' => 'required|max:15',
            'agents.*.departament' => 'max:200|nullable',
            'bank_data' => 'array|nullable',
            'bank_data.agency' => 'nullable|max:50|required_with:bank_data.checking_account',
            'bank_data.checking_account' => 'required_with:bank_data.agency',
            'bank_data.beneficiaries' => 'required_with:bank_data.agency',
            'bank_data.bank_id' => 'required_with:bank_data.checking_account'
        ];
    }

    public function attributes()
    {
        return [
            'agents.*.name' => 'nome do agente',
        ];
    }
}
