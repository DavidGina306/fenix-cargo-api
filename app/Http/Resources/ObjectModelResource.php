<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ObjectModelResource extends JsonResource
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
            "order" => $this->cabinet->order,
            'number' => $this->number,
            "entry_date" =>  Carbon::parse($this->cabinet->entry_date)->format('d M Y'),
            "id" => $this->id,
            "out_date" => $this->cabinet->out_date,
            "status" => $this->status,
            "quantity" => $this->quantity,
            'current_quantity' => $this->current_quantity,
            "width" => $this->width,
            "height" => $this->height,
            "length" => $this->length,
            "description" => $this->description,
            "position" => $this->position,
            "cubed_metric" => $this->cubed_metric,
            'cubed_weight' => $this->cubed_weight,
            "weight" => $this->weight,
            "customer" => [
                "id" => $this->cabinet->customer->id,
                "name" => $this->cabinet->customer->name,
                "role" => $this->cabinet->customer->role,
                "email" => $this->cabinet->customer->email,
                "email_2" => $this->cabinet->customer->email_2,
                "type" => $this->cabinet->customer->type,
                "document" => $this->cabinet->customer->document,
                "contact" => $this->cabinet->customer->contact,
                "status" => $this->cabinet->customer->status,
                "gender" => $this->cabinet->customer->gender,
            ],
            "locale" => [
                "id" => $this->locale->id,
                "name" => $this->locale->name,
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
            ],
            "medias" => $this->medias->map(function($query)  {
                return [
                    "url" => $query->url,
                ];
            }),
        ];
    }
}
