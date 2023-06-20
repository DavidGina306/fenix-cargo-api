<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            "interest" => $this->interest,
            "penalty" => $this->penalty,
            "type_invoice_id" => $this->type_invoice_id,
            "discount" => $this->discount,
            "value" => $this->value,
            "quantity" => $this->quantity,
            "due_date" => $this->due_date,
            "bank" => ["id" => $this->bank->id, "name" => $this->bank->name],
            "barcode" => $this->barcode,
            "note" => $this->note,
            "paymentType" => ["id" => $this->paymentType->id, "name" => $this->paymentType->name],
            "payer" => [
                "id" => $this->payer->id,
                "name" => $this->payer->name,
                "name" => $this->payer->name,
                "address_id" => $this->address->id,
                "address_line_1" => $this->address->address_line_1,
                "address_line_2" => $this->address->address_line_2,
                "address_line_3" => $this->address->address_line_3,
                "postcode" => $this->address->postcode,
                "town" => $this->address->town,
                "country" => $this->address->country,
                "state" => $this->address->state
            ],
            "number" => $this->number,
            "orders" => $this->orders
        ];
    }
}
