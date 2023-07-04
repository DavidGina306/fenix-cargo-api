<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  [
            "name" => $this->name,
            "document" => $this->document,
            "document_2" => $this->document_2,
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
                "country" => $this->address->country,
                "state" => $this->address->state
            ]
        ];
    }
}
