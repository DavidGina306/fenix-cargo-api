<?php

namespace App\Services\Cabinet;

use App\Helpers\MoneyToDecimal;
use App\Models\Cabinet;
use App\Models\Customer;
use App\Services\Address\StoreAddressService;
use App\Services\Cabinet\Object\StoreObjectService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class StoreCabinetService
{
    public static function store(array $request): Cabinet
    {
        try {
            $customer = Customer::query()->findOrFail($request['customer_id']);
            $address = StoreAddressService::store($request['address']);
            $cabinet = Cabinet::create(
                [
                    'order' => substr(str_shuffle(time() . mt_rand(0, 999) . md5(time() . mt_rand(0, 999))), 0, 16),
                    'customer_id' => $customer->id,
                    'address_id' => $address->id,
                    'status' => 'R',
                    'doc_value' => MoneyToDecimal::moneyToDecimal($request['nf_price']),
                    'storage_locale' => $request['storage'],
                    'entry_date' => isset($request['entry_date']) ? new Carbon($request['entry_date']) : Carbon::now()
                ]
            );
            StoreObjectService::storeAll($request['productData'], $cabinet->id);
            return $cabinet;
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Customer':
                    throw new Exception('Customer not found', 404);
                    break;
                case 'App\Models\Address':
                    throw new Exception('Address not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found in Cabinet', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Cabinet', 500);
        }
    }
}
