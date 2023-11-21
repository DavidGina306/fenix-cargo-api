<?php

namespace App\Services\Quote;

use App\Models\Order;
use App\Models\Quote;
use App\Models\Status;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class GenerateOrderByQuoteService
{
    public static function store($request)
    {
        try {
            $quote = Quote::query()->findOrFail($request);
            $order = Order::create(
                [
                    'delivery_type' => "",
                    "quote_id" => $quote->id,
                    'is_payer'  => $quote->customer->id,
                    'barcode'  => isset($request['barcode']) ? isset($request['barcode']) : null,
                    'obs'  => isset($request['obs']) ? isset($request['obs']) : null,
                    'number' => substr(str_shuffle(time() . mt_rand(0, 999) . md5(time() . mt_rand(0, 999))), 0, 16),
                    'doc_type_id' => $quote->docType->id,
                    //sender
                    'sender_id' =>  $quote->customer->id,
                    'sender_name' =>  $quote->customer->name,
                    'sender_search_for' => "",
                    'sender_address_id' => $quote->sender_address_id,
                    'phone_sender_search_for' => "",
                    //recipient
                    'recipient_id' =>  $quote->customer->id,
                    'recipient_name' =>  $quote->customer->name,
                    'recipient_search_for' => "",
                    'phone_recipient_search_for' => "",
                    'recipient_address_id' => $quote->recipient_address_id,
                    //about data
                    'status_id' => Status::query()->where('name', 'Aguardando Coleta')->first()->id,
                    //material
                    'material' => "",
                    'quantity' =>  $quote->products->sum('quantity'),
                    'height' =>  $quote->products->sum('height'),
                    'width' =>  $quote->products->sum('width'),
                    'length' =>  $quote->products->sum('length'),
                    'weight' => $quote->products->sum('weight'),
                    'value' => $quote->value,
                    "insurance_value" => $quote->insurance,
                    "insurance_percentage" => $quote->insurance_percentage,
                    'total_weight' => 0,
                    'open_date' => isset($request['open_date']) ? new Carbon($request['open_date']) : Carbon::now(),
                    'notes' => 'Observação',
                ]
            );
            return $order;
        } catch (\Exception $e) {
            Log::error($e);
            throw new Exception('Error to register Quote to Order', 500);
        }
    }
}
