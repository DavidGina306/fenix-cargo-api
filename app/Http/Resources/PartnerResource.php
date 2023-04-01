<?php

namespace App\Http\Resources;

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
            "email" => $this->email,
            "email_2" => $this->email_2,
            "contact" => $this->contact,
            "contact_phone" => $this->contact_phone,
            "contact_2_phone" => $this->contact_2_phone,
            "agents" => $this->agents->map(function ($query) {
                return [
                    "id" => $query->id,
                    "name" => $query->name,
                    "email" => $query->email,
                    "contact" => $query->contact
                ];
            }),
            "bank_data" =>
            [
                "id" =>  $this->bankData->id,
                "agency" =>  $this->bankData->agency,
                "checking_account" =>  $this->bankData->checking_account,
                "pix" =>  $this->bankData->pix,
                "beneficiaries" =>  $this->bankData->beneficiaries,
                "bank_id" =>  $this->bankData->bank_id,
            ],
            "address" => [
                "id" => $this->address->id,
                "address_line_1" => $this->address->address_line_1,
                "address_line_2" => $this->address->address_line_2,
                "address_line_3" => $this->address->address_line_3,
                "postcode" => $this->address->postcode,
                "town" => $this->address->town,
                "country" => $this->address->country,
                "state" => $this->address->state
            ]
        ];
    }
}
