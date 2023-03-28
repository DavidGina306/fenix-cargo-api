<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ListOrderMovementToTimelineResource extends JsonResource
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
            "number" => $this->number,
            "status" => $this->status,
            "orderMovements" => $this->orderMovements->map(function($query)  {
                return [
                    "id" => $query->id,
                    "status" => $query->status,
                    "entry_date"=> Carbon::parse($query->entry_date),
                    "doc_received_for"=> $query->doc_received_for,
                    "received_for" =>$query->received_for,
                    'timestamp' => Carbon::parse($query->entry_date),
                    'title' => 'Alterando status para '.$query->status->name . ' responsável '. $query->received_for
                ];
            })
        ];
    }
}
