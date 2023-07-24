<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RelationPriceResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'deadline_initial' => $this->deadline_initial,
            'deadline_final' => $this->deadline_final,
            'destiny_country' => $this->destiny_country,
            'destiny_1' => $this->destiny_1,
            'destiny_2' => $this->destiny_2,
            'origin_country' => $this->origin_country,
            'origin_state' => $this->origin_state,
            'origin_city' => $this->origin_city,
            'value' => $this->value,
            'weight_initial' => $this->weight_initial,
            'weight_final' => $this->weight_final,
            'local_type' => $this->local_type,
            'status' => $this->status,
            'partner_id' => $this->partner_id,
            'fee_type_id' => $this->fee_type_id,
            'fee_rule_id' => $this->fee_rule_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deadline_type' => $this->deadline_type,
            'currency_id' => $this->currency_id,
            'type' => $this->type,
        ];
    }
}
