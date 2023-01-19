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
            "entry_date" =>  Carbon::parse($this->cabinet->entry_date)->format('d M Y') ,
            "id" => $this->id,
            "out_date" => $this->cabinet->out_date,
            "locale" => $this->locale->name,
            "status" => $this->status,
            "quantity" => $this->quantity,
            "width"=> $this->width,
            "height" =>$this->height,
            "length" =>$this->length,
            "description" =>$this->description,
            "cubed_metric" => $this->cubed_metric,
            'cubed_weight' => $this->cubed_weight,
            "weight" =>$this->weight,
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
        ];
    }
}
