<?php

namespace App\Services\Quote;

use App\Helpers\MoneyToDecimal;
use App\Models\AdditionalFee;
use App\Models\Address;
use App\Models\Country;
use App\Models\Customer;
use App\Models\DocType;
use App\Models\FeeType;
use App\Models\Quote;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class StoreQuoteService
{

    public static function store($request): Quote
    {
        try {
            $documentType = DocType::query()->findOrFail($request['doc_type_id']);
            $customer = Customer::query()->findOrFail($request['customer_id']);
            $senderAddress = self::storeAddressSender($request);
            $receiveAddress = self::storeAddressReceive($request);

            $quote = Quote::create(
                [
                    'number' => substr(str_shuffle(time() . mt_rand(0, 999) . md5(time() . mt_rand(0, 999))), 0, 16),
                    'comment_1' => $request['comment_1'] ?? null,
                    'comment_2' => $request['comment_2'] ?? null,
                    'doc_type_id' =>  $documentType->id,
                    'sender_address_id' => $senderAddress->id,
                    'recipient_address_id' => $receiveAddress->id,
                    "insurance_percentage" => MoneyToDecimal::moneyToDecimal($request["insurance"]),
                    'insurance' => MoneyToDecimal::moneyToDecimal($request['quote']['seguro']),
                    'value' => MoneyToDecimal::moneyToDecimal($request['quote']['totalValue']),
                    'flat_fee' => MoneyToDecimal::moneyToDecimal($request['quote']['flatFee']),
                    'fee' => MoneyToDecimal::moneyToDecimal($request['quote']['fee']),
                    'excess_weight' => MoneyToDecimal::moneyToDecimal($request['quote']['excessWeight']),
                    'minimum_fee' => MoneyToDecimal::moneyToDecimal($request['quote']['minimumFee']),
                    'customer_id' => $customer->id
                ]
            );
            foreach ($request['productData'] as $object) {
                $quote->products()->create([
                        'quantity' => $quantity = intval($object['quantity']),
                        'height' => $height = self::cleanCentrimetricValue($object['height']),
                        'width' => $width = self::cleanCentrimetricValue($object['width']),
                        'length' => $length =  self::cleanCentrimetricValue($object['length']),
                        'weight' => self::cleanWeightValue($object['weight']),
                        'cubed_weight' => self::calculateCubedWeight([
                            'quantity' => $quantity,
                            'height' => $height,
                            'width' => $width,
                            'length' => $length
                        ])
                ]);
            }

            $objectsToSync = [];

            foreach ($request['fees'] as $value) {
                // Buscar o objeto com base no número
                $object = AdditionalFee::find($value['additional_fee_id']);

                if ($object) {
                    $objectsToSync[$object->id] = ['value' => MoneyToDecimal::moneyToDecimal($value['additional_price'])];
                }
            }
            $quote->additionalFees()->sync($objectsToSync);
            return $quote;
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Customer':
                    throw new Exception('Customer not found', 404);
                    break;
                case 'App\Models\DocType':
                    throw new Exception('DocType not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Quote', 500);
        }
    }

    public static function cleanCentrimetricValue($value): float
    {
        return floatval(str_replace(',', '.', str_replace('cm', '', $value)));
    }


    public static function cleanWeightValue($value): float
    {
        return floatval(str_replace(',', '.', str_replace('kg', '', $value)));
    }

    public static function calculateCubedWeight(array $object): float
    {
        return ($object['height'] * $object['width'] * $object['length'] * $object['quantity']) / 6000;
    }

    public static function calculateWeightTotal(array $object): float
    {
        $cubedWeight = self::calculateCubedWeight($object);
        return max($object['weight'], $cubedWeight);
    }

    public static function storeAddressSender($request): Address
    {
        try {
            $country = Country::query()->findOrFail($request['sender_address_country']);

            return Address::query()->create([
                'address_line_1' => $request['sender_address_line_1'],
                'address_line_2' => $request['sender_address_line_2'],
                'address_line_3' => $request['sender_address_line_3'] ?? "",
                'town' => $request['sender_address_town'],
                'country' => $country->nome,
                'state' => $request['sender_address_states'],
                'postcode' => $request['sender_postcode']
            ]);
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Country':
                    throw new Exception('Country not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Sender Address Quote', 500);
        }
    }

    public static function storeAddressReceive($request): Address
    {
        try {
            $country = Country::query()->findOrFail($request['receive_address_country']);

            return Address::query()->create([
                'address_line_1' => $request['receive_address_line_1'],
                'address_line_2' => $request['receive_address_line_2'],
                'address_line_3' => $request['receive_address_line_3'] ?? "",
                'town' => $request['receive_address_town'],
                'country' => $country->nome,
                'state' => $request['receive_address_states'],
                'postcode' => $request['receive_postcode']
            ]);
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Country':
                    throw new Exception('Country not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Receive Address Quote', 500);
        }
    }
}
