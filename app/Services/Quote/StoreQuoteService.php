<?php

namespace App\Services\Quote;

use App\Models\Address;
use App\Models\Customer;
use App\Models\DocType;
use App\Models\FeeType;
use App\Models\Quote;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class StoreQuoteService
{
    public static function store($request)
    {
        try {
            $documentType = DocType::query()->findOrFail($request['doc_type_id']);
            $customer = Customer::query()->findOrFail($request['customer_id']);
            $feeType = FeeType::query()->findOrFail($request['fee_type_id']);
            $user = Quote::create(
                [
                    'number' => substr(str_shuffle(time() . mt_rand(0, 999) . md5(time() . mt_rand(0, 999))), 0, 16),
                    'comment_1' => $request['comment_1'] ?? null,
                    'comment_2' => $request['comment_2'],
                    'width' => $request['width'],
                    'quantity' => $request['quantity'],
                    'length' => 0,
                    'height' => $request['height'],
                    'cubed_weight' => $request['cubed_weight'],
                    'add_price' => $request['add_price'] ?? 0,
                    'doc_type_id' =>  $documentType->id,
                    'length' => $request['length'],
                    'fee_type_id' => $feeType->id,
                    'sender_address_id' => Address::first()->id,
                    'recipient_address_id' => Address::first()->id,
                    'value' => 0,
                    'customer_id' => $customer->id
                ]
            );
            return $user;
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Customer':
                    throw new Exception('Customer not found', 404);
                    break;
                case 'App\Models\DocType':
                    throw new Exception('DocType not found', 404);
                    break;
                case 'App\Models\FeeType':
                    throw new Exception('FeeType not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Quote', 500);
        }
    }
}
