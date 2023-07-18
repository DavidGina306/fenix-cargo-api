<?php

namespace App\Http\Resources;

use App\Models\Country;
use Illuminate\Support\Optional;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $bankData = $this->bankData;
        return [
            "name" => $this->name,
            "document" => $this->document,
            "document_2" => $this->document_2,
            "profile" => $this->profile,
            "id" => $this->id,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "gender" => $this->gender,
            "type" => $this->type,
            "agents" => $this->agents->map(function ($query) {
                return [
                    "id" => $query->id,
                    "name" => $query->name,
                    "email" => $query->email,
                    "contact" => $query->contact,
                    "departament" => $query->departament
                ];
            }),
            "address" => [
                "id" => $this->address->id,
                "address_line_1" => $this->address->address_line_1,
                "address_line_2" => $this->address->address_line_2,
                "address_line_3" => $this->address->address_line_3,
                "postcode" => $this->address->postcode,
                "town" => $this->address->town,
                "country" => Country::whereNome($this->address->country)->first()->id ?? "Brasil",
                "state" => $this->address->state
            ],
            "bank_data" => [
                "id" => $bankData->id ?? null,
                "agency" => $bankData->agency ?? null,
                "checking_account" => $bankData->checking_account ?? null,
                "pix" => $bankData->pix ?? null,
                "beneficiaries" => $bankData->beneficiaries ?? null,
                "bank_id" => $bankData->bank_id ?? null,
                "bills" => isset($bankData->bills) ? true : false
            ]
        ];
    }
}
