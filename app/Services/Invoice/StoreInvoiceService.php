<?php

namespace App\Services\Invoice;

use App\Helpers\MoneyToDecimal;
use App\Models\Customer;
use App\Models\DocType;
use App\Models\Locale;
use App\Models\ObjectModel;
use App\Models\Order;
use App\Models\PackingType;
use App\Models\Status;
use App\Services\Address\StoreAddressService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class StoreInvoiceService
{
    public static function store($request)
    {
        try {
            $customerSender = isset($request['sender_id']) ? Customer::query()->findOrFail($request['sender_id']) : null;
            $customerRecipient = isset($request['recipient_id']) ? Customer::query()->findOrFail($request['recipient_id']) : null;
            $addressSender = StoreAddressService::store($request['address_sender']);
            $addressRecipient = StoreAddressService::store($request['address_recipient']);
            $typePacking = isset($request['packing_type_id']) ? PackingType::query()->findOrFail($request['packing_type_id']) : null;
            $docType = isset($request['doc_type_id']) ? DocType::query()->findOrFail($request['doc_type_id']) : null;
            $locale = isset($request['locale_id']) ?  Locale::query()->findOrFail($request['locale_id']) : '';
            $order = Order::create(
                [
                    'delivery_type' => $request['delivery_type'],
                    'is_payer'  => $request['is_payer'],
                    'barcode'  => isset($request['barcode']) ? isset($request['barcode']) : null,
                    'obs'  => isset($request['obs']) ? isset($request['obs']) : null,
                    'number' => substr(str_shuffle(time() . mt_rand(0, 999) . md5(time() . mt_rand(0, 999))), 0, 16),
                    'packing_type_id' => $typePacking  ? $typePacking->id : null,
                    'doc_type_id' => $docType  ? $docType->id : null,
                    //sender
                    'sender_id' =>  $customerSender  ? $customerSender->id : null,
                    'sender_name' =>  $customerSender  ? $customerSender->name : $request['sender_name'],
                    'sender_search_for' => $request['sender_search_for'],
                    'sender_address_id' => $addressSender->id,
                    'phone_sender_search_for' => $request['phone_sender_search_for'],
                    //recipient
                    'recipient_id' =>  $customerRecipient  ? $customerRecipient->id : null,
                    'recipient_name' =>  $customerRecipient  ? $customerRecipient->name :  $request['recipient_name'],
                    'recipient_search_for' => $request['recipient_search_for'],
                    'phone_recipient_search_for' => $request['phone_recipient_search_for'],
                    'recipient_address_id' => $addressRecipient->id,
                    //about data
                    'locale_id' => $locale ? $locale->id : null,
                    'status_id' => Status::query()->where('name', 'Aguardando Coleta')->first()->id,
                    //material
                    'material' => $request['material'],
                    'quantity' =>  $request['quantity'],
                    'height' =>  $request['height'],
                    'width' =>  $request['width'],
                    'length' =>  $request['length'],
                    'weight' => $request['weight'],
                    'value' => MoneyToDecimal::moneyToDecimal($request['total']),
                    'total_weight' => 0,
                    'open_date' => isset($request['open_date']) ? new Carbon($request['open_date']) : Carbon::now(),
                    'notes' => 'Observação',
                    'payer_id' => self::setPayer($request['is_payer'], $customerSender, $customerRecipient)
                ]
            );
            return $order;
        } catch (\Exception $e) {
            Log::error($e);
            throw new Exception('Error to register Order', 500);
        }
    }

    private static function setPayer($isPayer, $customerSender, $customerRecipient)
    {
        if ($isPayer == 1 && $customerSender) {
            return $customerSender->id;
        } else if ($isPayer == 1 && $customerRecipient) {
            return $customerRecipient->id;
        }
        return null;
    }

    public static function storeSingleItem($request)
    {
        try {
            $object = ObjectModel::query()->whereNumber($request['item']['number'])->first();
            $address = StoreAddressService::store($request['address']);
            $order = Order::create(
                [
                    'number' => substr(str_shuffle(time() . mt_rand(0, 999) . md5(time() . mt_rand(0, 999))), 0, 16),
                    'customer_id' =>  $object->customer->id,
                    'address_id' => $address->id,
                    'locale_id' => $object->locale->id,
                    'status_id' => Status::query()->where('name', 'Aguardando Coleta')->first()->id,
                    'quantity' =>  $request['item']['quantity'],
                    'value' => 0,
                    'total_weight' => $request['item']['total_weight'],
                    'open_date' => isset($request['open_date']) ? new Carbon($request['open_date']) : Carbon::now(),
                    'notes' => 'Observação'
                ]
            );
            $items[] = $request['item'];
            self::storeItems($items, $order);
            return $order;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Order', 500);
        }
    }

    public static function storeItems(array $data, Order $order)
    {
        try {
            foreach ($data as $item) {
                $object = ObjectModel::query()->whereNumber($item['number'])->first();
                $order->objects()->attach($object->id, ['current_quantity' => $item['quantity']]);
                $object->update([
                    'current_quantity' => $object->current_quantity - $item['quantity']
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register objects to Order', 500);
        }
    }
}
