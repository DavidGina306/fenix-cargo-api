<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CabinetResource extends JsonResource
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
            "order" => $this->order,
            "entry_date" =>  Carbon::parse($this->entry_date)->format('d M Y') ,
            "id" => $this->id,
            "out_date" => $this->out_date,
            "status" => $this->status,
            "gender" => $this->gender,
            "doc_value" => $this->doc_value,
            "storage_locale" => $this->storage_locale,
            "objects" => $this->objects->map(function($query)  {
                return [
                    "id" => $query->id,
                    "quantity" => $query->quantity,
                    "width"=> $query->width,
                    "height" =>$query->height,
                    "length" =>$query->length,
                    "cubed_weight" =>$query->cubed_weight
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
            ],
            "customer" => [
                "id" => $this->customer->id,
                "name" => $this->customer->name,
                "role" => $this->customer->role,
                "email" => $this->customer->email,
                "email_2" => $this->customer->email_2,
                "type" => $this->customer->type,
                "document" => $this->customer->document,
                "contact" => $this->customer->contact,
                "status" => $this->customer->status,
                "gender" => $this->customer->gender,
            ],
        ];
    }
}
