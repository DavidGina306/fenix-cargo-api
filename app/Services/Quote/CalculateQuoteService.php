<?php

namespace App\Services\Quote;

use App\Helpers\MoneyToDecimal;
use App\Models\RelationPrice;
use Exception;
use Illuminate\Support\Facades\Log;

class CalculateQuoteService
{
    public static function sumQuote($request): array
    {
        try {
            $objects = self::calculateWeightForObjects($request["productData"]);
            $totalWeight = array_sum(array_column($objects, 'weight_total'));
            return [
                "byCep" => self::calculateByFeeType($request, $totalWeight, "Rota CEP"),
                "dedicatedTruck" => self::calculateByFeeType($request, $totalWeight, "Caminhão Exclusivo"),
                "conventionalAircraft" => self::calculateByFeeType($request, $totalWeight, "Aéreo Convencional"),
                "roadTransportType" => self::calculateByFeeType($request, $totalWeight, "Rodoviário"),
                "urgentAircraft" => self::calculateByFeeType($request, $totalWeight, "Aéreo Urgente"),
            ];
        } catch (\Exception $e) {
            Log::error($e);
            throw new Exception('Error to calculate Quote', 500);
        }
    }

    public static function getValueByFeeRuleAndFeeType(array $address, string $feeRule, $feeType, $totalWeight)
    {
        $relation =  RelationPrice::whereHas('feeRule', function ($q) use ($feeRule) {
            $q->where('name', $feeRule);
        })->whereHas('feeType', function ($q) use ($feeType) {
            $q->where('name', $feeType);
        })->where(function ($query) use ($address) {
            $query->where('origin_city', 'LIKE', $address['sender_address_town'])
                ->where('origin_state', 'LIKE', $address['sender_address_states'])
                ->where('destiny_1', 'LIKE', $address['receive_address_states'])
                ->where('destiny_2', 'LIKE', $address['receive_address_town']);
        })->where(function ($query) use ($totalWeight, $feeRule) {
            if ($feeRule == 'Excedente') {
                $query->where('weight_initial', "<=", $totalWeight)
                    ->where('weight_final', ">=", $totalWeight)
                    ->where('above_excess_weight', "<=", $totalWeight);
            } else {
                $query->where('weight_initial', "<=", $totalWeight)
                    ->where('weight_final', ">=", $totalWeight);
            }
        });
        return $relation->get();
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

    public static function calculateWeightForObjects(array $objects): array
    {
        $data = [];

        try {
            foreach ($objects as $object) {
                $data[] = [
                    'quantity' => $quantity = intval($object['quantity']),
                    'height' => $height = self::cleanCentrimetricValue($object['height']),
                    'width' => $width = self::cleanCentrimetricValue($object['width']),
                    'length' => $length =  self::cleanCentrimetricValue($object['length']),
                    'weight' => $weight = self::cleanWeightValue($object['weight']),
                    'cubed_weight' => self::calculateCubedWeight([
                        'quantity' => $quantity,
                        'height' => $height,
                        'width' => $width,
                        'length' => $length
                    ]),
                    'weight_total' => self::calculateWeightTotal([
                        'quantity' => $quantity,
                        'height' => $height,
                        'width' => $width,
                        'length' => $length,
                        'weight' => $weight
                    ]),
                ];
            }
            return $data;
        } catch (Exception $ex) {
            Log::error($ex);
            throw new Exception('Error to calculate Weight for Quote', 500);
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

    public static function calculateByFeeType(array $data, float $totalWeight, string $feeType): array
    {
        $excess = self::getValueByFeeRuleAndFeeType($data, "Excedente", $feeType, $totalWeight);
        $minimun = self::getValueByFeeRuleAndFeeType($data, "Taxa Minima", $feeType, $totalWeight);
        $flatFee = self::getValueByFeeRuleAndFeeType($data, "Taxa fixa por kg", $feeType, $totalWeight);

        $excessValue = !empty($excess) && isset($excess[0]->value) ? $excess[0]->value : 0;
        $minimumValue = !empty($minimun) && isset($minimun[0]->value) ? $minimun[0]->value : 0;
        $flatFeeValue = !empty($flatFee) && isset($flatFee[0]->value) ? $flatFee[0]->value : 0;
        $insurance = self::calculateInsurance($data["nf_price"], $data["insurance"]);
        $fees = isset($data['fees']) ? array_sum(array_column($data['fees'], 'additional_price')) : 0;

        return [
            "fee" => $fees,
            "excessWeight" => $excessValue,
            "minimumFee" => $minimumValue,
            "flatFee" => $flatFeeValue,
            "seguro" => $insurance,
            "totalValue" => $excessValue || $minimumValue || $flatFeeValue ?
                number_format($minimumValue + self::calculateExcess($totalWeight, $excessValue) +
                    self::calculateFlatFee($totalWeight, $flatFeeValue) +
                    $insurance + $fees, 2, ',', '.')  : 0
        ];
    }

    public static function calculateInsurance($documentValue, $insuranceValue)
    {
        $insurance = (MoneyToDecimal::moneyToDecimal($documentValue) * $insuranceValue);
        return $insurance;
    }

    public static function calculateExcess(float $totalWeight, float $excess): float
    {
        return $totalWeight * $excess;
    }

    public static function calculateFlatFee(float $totalWeight, float $flatFee): float
    {
        return $totalWeight * $flatFee;
    }
}
