<?php

namespace App\Services\Invoice;

use App\Helpers\MoneyToDecimal;
use App\Http\Controllers\Api\InvoiceController;
use App\Models\Bank;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\PaymentType;
use App\Models\Status;
use App\Services\Address\StoreAddressService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class StoreInvoiceService
{
    public static function store($request)
    {
        try {
            $payer = Customer::query()->findOrFail($request['payer']['id']);
            $bank = Bank::query()->findOrFail($request['bank_id']);
            $address = StoreAddressService::store($request['payer']);
            $paymentType = PaymentType::query()->findOrFail($request['payment_type_id']);
            $invoice = Invoice::create(
                [
                    'type_invoice_id' => $request['type_invoice_id'],
                    'barcode'  => isset($request['bar_code']) ? isset($request['bar_code']) : null,
                    'note'  => isset($request['obs']) ? isset($request['obs']) : null,
                    'number' => substr(str_shuffle(time() . mt_rand(0, 999) . md5(time() . mt_rand(0, 999))), 0, 16),
                    'quantity' =>  $request['quantity'],
                    'discount' =>  MoneyToDecimal::moneyToDecimal($request['discount']),
                    'penalty' =>   MoneyToDecimal::moneyToDecimal($request['penalty']),
                    'interest' =>  MoneyToDecimal::moneyToDecimal($request['interest']),
                    'value' => MoneyToDecimal::moneyToDecimal($request['value']),
                    'due_date' => isset($request['due_date']) ? new Carbon($request['due_date']) : Carbon::now(),
                    'note' => 'Observação',
                    'payer_id' => $payer->id,
                    'bank_id' => $bank->id,
                    'payer_address_id' => $address->id,
                    'payment_type_id' => $paymentType->id

                ]
            );
            if($request['type_invoice_id'] == 'M') {
                self::setOrderstoInvoices($invoice, $request['items']);
            } else {

            }
            return $invoice;
        } catch (ModelNotFoundException $e) {
            Log::error($e);
            switch ($e->getModel()) {
                case 'App\Models\Customer':
                    throw new Exception('Customer not found', 404);
                    break;
                case 'App\Models\PaymentType':
                    throw new Exception('PaymentType not found', 404);
                    break;
                case 'App\Models\Bank':
                    throw new Exception('Bank not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e);
            throw new Exception('Error to register Invoice', 500);
        }
    }

    public static function setOrderstoInvoices(Invoice $invoice, array $orders)
    {
        try {
            foreach ($orders as $data) {
                $order = Order::query()->where('number', $data['number'])->first();
                if ($order) {
                    $invoice->orders()->attach($order->id);
                    $order->update([
                        'status_id' => Status::query()->where('group', 'order')->where('letter', 'F')->first()->id
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error($e);
            throw new Exception('Error to set Order in  Invoice', 500);
        }
    }
}
