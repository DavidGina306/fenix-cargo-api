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
        return  [
            "name" => $this->name,
            "number_doc" => $this->number_doc,
            "id" => $this->id,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "address" => [
                "id" => $this->address->id,
                "address_line_1" => $this->address->address_line_1,
                "address_line_2" => $this->address->address_line_2,
                "address_line_3" => $this->address->address_line_3,
                "postcode" => $this->address->postcode,
                "town" => $this->address->town,
                "country" => $this->address->country
            ],
            "agents" => [

            ]
        ];
    }
}
