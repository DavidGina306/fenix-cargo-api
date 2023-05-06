<?php

namespace App\Services\Order;

use App\Helpers\MoneyToDecimal;
use App\Models\Customer;
use App\Models\DocType;
use App\Models\Locale;
use App\Models\Order;
use App\Models\PackingType;
use App\Models\Status;
use App\Services\Address\UpdateAddressService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdateOrderService
{
    public static function update(array $request, string $orderId)
    {
        try {
            $order = Order::query()->findOrFail($orderId);
            $customerPayer = Customer::query()->findOrFail($request['payer']['id']);
            $customerSender = isset($request['sender_id']) ? Customer::query()->findOrFail($request['sender_id']) : null;
            $customerRecipient = isset($request['recipient_id']) ? Customer::query()->findOrFail($request['recipient_id']) : null;
            UpdateAddressService::update($request['payer'], $order->addressPayer->id);
            UpdateAddressService::update($request['address_sender'], $order->addressSender->id);
            UpdateAddressService::update($request['address_recipient'], $order->addressRecipient->id);
            $typePacking = PackingType::query()->findOrFail($request['packing_type_id']);
            $docType = DocType::query()->findOrFail($request['doc_type_id']);
            $locale = isset($request['locale_id']) ?  Locale::query()->findOrFail($request['locale_id']) : '';
            $order->update([
                'delivery_type' => $request['delivery_type'],
                'barcode'  => isset($request['barcode']) ? isset($request['barcode']) : null,
                'obs'  => isset($request['obs']) ? isset($request['obs']) : null,
                'packing_type_id' => $typePacking->id,
                'doc_type_id' => $docType->id,
                //sender
                'sender_id' =>  $customerSender  ? $customerSender->id : null,
                'sender_name' =>  $customerSender  ? $customerSender->name : $request['sender_name'],
                'sender_search_for' => $request['sender_search_for'],
                'phone_sender_search_for' => $request['phone_sender_search_for'],
                //recipient
                'recipient_id' =>  $customerRecipient  ? $customerRecipient->id : null,
                'recipient_name' =>  $customerRecipient  ? $customerRecipient->name :  $request['recipient_name'],
                'recipient_search_for' => $request['recipient_search_for'],
                'phone_recipient_search_for' => $request['phone_recipient_search_for'],
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
                'payer_id' => $customerPayer->id,
                'freight_value' =>  MoneyToDecimal::moneyToDecimal($request['freight_value']),
                'insurance_percentage' => MoneyToDecimal::moneyToDecimal($request['insurance_percentage']),
                'insurance_value' => MoneyToDecimal::moneyToDecimal($request['insurance_value']),
            ]);
            return $order;
        } catch (ModelNotFoundException $e) {
            Log::error($e);
            switch ($e->getModel()) {
                case 'App\Models\Order':
                    throw new Exception('Order not found', 404);
                    break;
                case 'App\Models\PackingType':
                    throw new Exception('PackingType not found', 404);
                    break;
                case 'App\Models\DocType':
                    throw new Exception('DocType not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Order', 500);
        }
    }
}
