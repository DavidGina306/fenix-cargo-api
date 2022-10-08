<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RelationPriceResource extends JsonResource
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
            "deadline_type" => $this->deadline_type,
            "deadline_initial" => $this->deadline_initial,
            "id" => $this->id,
            "weight_final" => $this->weight_final,
            "deadline_final" => $this->deadline_final,
            "destiny_type" => $this->destiny_type,
            "destiny_initial" => $this->destiny_initial,
            "destiny_final" => $this->destiny_final,
            "destiny_state" => $this->destiny_state,
            "origin_type" => $this->origin_type,
            "origin_initial" => $this->origin_initial,
            "origin_state" => $this->origin_state,
            "relationPriceDetails" => $this->relationPriceDetails->map(function($query)  {
                return [
                    "id" => $query->id,
                    "value" => $query->value,
                    "weight_initial"=> $query->weight_initial,
                    "weight_final" => $query->weight_final,
                    'currency' => $query->currency()->select('id', 'name')->get(),
                    'feeRule'=> $query->feeRule()->select('id', 'name')->get()
                ];
            }),
            "partner" => [
                $this->partner()->select('name', 'id')->get()
            ]
        ];
    }
}
