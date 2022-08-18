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
            "id" => $this->id,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "gender" => $this->gender,
            "email" => $this->email,
            "email_2" => $this->email_2,
            "contact" => $this->contact,
            "contact_2" => $this->contact_2,
        ];
    }
}
