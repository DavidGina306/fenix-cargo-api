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
            $payer = Customer::query()->findOrFail($request['payer']['id']);
            $order = Order::create(
                [
                    'type_invoice_id' => $request['type_invoice_id'],
                    'is_payer'  => $request['is_payer'],
                    'barcode'  => isset($request['barcode']) ? isset($request['barcode']) : null,
                    'note'  => isset($request['obs']) ? isset($request['obs']) : null,
                    'number' => substr(str_shuffle(time() . mt_rand(0, 999) . md5(time() . mt_rand(0, 999))), 0, 16),
                    'status_id' => Status::query()->where('name', 'Aguardando Coleta')->first()->id,
                    //material
                    'quantity' =>  $request['quantity'],
                    'discount' =>  MoneyToDecimal::moneyToDecimal($request['discount']),
                    'penalty' =>   MoneyToDecimal::moneyToDecimal($request['penalty']),
                    'interest' =>  MoneyToDecimal::moneyToDecimal($request['interest']),,
                    'value' => MoneyToDecimal::moneyToDecimal($request['value']),
                    'due_date' => isset($request['due_date']) ? new Carbon($request['due_date']) : Carbon::now(),
                    'notes' => 'Observação',
                    'payer_id' => $payer->id
                ]
            );
            return $order;
        } catch (\Exception $e) {
            Log::error($e);
            throw new Exception('Error to register Order', 500);
        }
    }
}
