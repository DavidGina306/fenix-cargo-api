<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ListOrderWarningToEditResource extends JsonResource
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
            "warnings" => $this->warnings->map(function($query)  {
                return [
                    "id" => $query->id,
                    "profile" => $query->profile,
                    "contact" => $query->contact,
                    "partner" => $query->partner,
                    "is_whatsapp" => $query->is_whatsapp,
                    "value" => $query->value,
                    "entry_date"=> Carbon::parse($query->entry_date)->format('d/m/Y'),
                    'timestamp' => Carbon::parse($query->entry_date),
                    'files' => []
                ];
            })
        ];
    }
}
