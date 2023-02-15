<?php

namespace App\Services\Order;

use App\Models\Customer;
use App\Models\Locale;
use App\Models\ObjectModel;
use App\Models\Order;
use App\Services\Address\StoreAddressService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class StoreOrderService
{
    public static function store($request)
    {
        try {
            $customer = Customer::query()->findOrFail($request['customer_id']);
            $address = StoreAddressService::store($request['address']);
            $locale = Locale::query()->findOrFail($request['locale_id']);
            $order = Order::create(
                [
                    'number' => substr(str_shuffle(time() . mt_rand(0, 999) . md5(time() . mt_rand(0, 999))), 0, 16),
                    'customer_id' => $customer->id,
                    'address_id' => $address->id,
                    'locale_id' => $locale->id,
                    'status' => 'W',
                    'quantity' =>  array_sum(array_column($request['items'], 'quantity')),
                    'value' => 0,
                    'total_weight' => array_sum(array_column($request['items'], 'total_weight')),
                    'open_date' => isset($request['open_date']) ? new Carbon($request['open_date']) : Carbon::now(),
                    'notes' => 'Observação'
                ]
            );
            self::storeItems($request['items'], $order);
            return $order;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Order', 500);
        }
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
                    'status' => 'W',
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
            Log::warning($data);
            foreach ($data as $item) {
                $object = ObjectModel::query()->whereNumber($item['number'])->first();
                $order->objects()->attach($object->id, ['current_quantity' => $item['quantity']]);
                $object->update([
                    'current_quantity' => $item['quantity'] - $object->current_quantity
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register objects to Order', 500);        }
    }
}
