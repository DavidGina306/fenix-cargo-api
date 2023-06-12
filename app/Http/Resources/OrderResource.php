<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            "is_payer" => $this->is_payer,
            "delivery_type" => $this->delivery_type,
            "material" => $this->material,
            "doc_type_id" => $this->doc_type_id,
            "payer_id" => $this->payer_id,
            "packing_type_id" => $this->packing_type_id,
            "sender_name" => $this->sender_name,
            "sender_search_for" => $this->sender_search_for,
            "phone_sender_search_for" => $this->phone_sender_search_for,
            "recipient_name" => $this->recipient_name,
            "recipient_search_for" => $this->recipient_search_for,
            "phone_recipient_search_for" => $this->phone_recipient_search_for,
            "sender_id" => $this->sender_id,
            "recipient_name" => $this->recipient_name,
            "recipient_search_for" => $this->recipient_search_for,
            "phone_recipient_search_for" => $this->phone_recipient_search_for,
            "recipient_id" => $this->recipient_id,
            "notes" => $this->notes,
            "open_date" => $this->open_date,
            "total_weight" => $this->total_weight,
            "value" => $this->value,
            "quantity" => $this->quantity,
            "height" => $this->height,
            "width" => $this->width,
            "weight" => $this->weight,
            "length" => $this->length,
            "value" => $this->value,
            "address_sender" => [
                "id" => $this->addressSender->id,
                "address_line_1" => $this->addressSender->address_line_1,
                "address_line_2" => $this->addressSender->address_line_2,
                "address_line_3" => $this->addressSender->address_line_3,
                "postcode" => $this->addressSender->postcode,
                "town" => $this->addressSender->town,
                "country" => $this->addressSender->country,
                "state" => $this->addressSender->state
            ],
            "address_recipient" => [
                "id" => $this->addressRecipient->id,
                "address_line_1" => $this->addressRecipient->address_line_1,
                "address_line_2" => $this->addressRecipient->address_line_2,
                "address_line_3" => $this->addressRecipient->address_line_3,
                "postcode" => $this->addressRecipient->postcode,
                "town" => $this->addressRecipient->town,
                "country" => $this->addressRecipient->country,
                "state" => $this->addressRecipient->state
            ],
            "number" => $this->number
        ];
    }
}
