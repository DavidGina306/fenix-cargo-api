<?php

namespace App\Services\RelationPrice;

use App\Enums\RelationPriceType;
use App\Helpers\MoneyToDecimal;
use App\Models\Currency;
use App\Models\FeeRule;
use App\Models\FeeType;
use App\Models\Partner;
use App\Models\RelationPrice;
use App\Services\Country\GetCountryService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StoreRelationPriceService
{
    /**
     * Function created to register RelationPrice
     *
     * @param array $request
     * @return RelationPrice|array
     */
    public static function store(array $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $relationPrices = [];
                foreach ($request['rule_types'] as $rule) {
                    $partner = self::getPartnerById($request['partner_id']);
                    $feeType = self::getFeeTypeById($request['fee_type_id']);
                    $feeRule = self::getFeeRuleById($rule['fee_rule_id']);
                    $currency = self::getCurrencyById($rule['currency_id']);

                    $relationPrice = RelationPrice::query()->firstOrCreate([
                        'number' => substr(str_shuffle(time() . mt_rand(0, 999) . md5(time() . mt_rand(0, 999))), 0, 16),
                        'destiny_1' => $request['destiny_1'],
                        'destiny_2' => $request['destiny_2'],
                        'type' => $request['type'],
                        "destiny_country" => GetCountryService::searchById($request['destiny_country'])->id,
                        "local_type" => $request['local_type'] ?? false,
                        'origin_city' => $request['origin_city'],
                        'origin_country' => GetCountryService::searchById($request['origin_country'])->id,
                        'origin_state' => $request['origin_state'],
                        'deadline_type' => $request['deadline_type'],
                        'deadline_initial' => $request['deadline_initial'],
                        'deadline_final' => $request['deadline_final'] ?? "",
                        'value' => MoneyToDecimal::moneyToDecimal($rule['value']),
                        'weight_initial' => MoneyToDecimal::moneyToDecimal($rule['weight_initial']),
                        'weight_final' => MoneyToDecimal::moneyToDecimal($rule['weight_final']) ?? "",
                        'fee_rule_id' => optional($feeRule)->id,
                        'partner_id' => optional($partner)->id,
                        'fee_type_id' => optional($feeType)->id,
                        'currency_id' => optional($currency)->id,
                    ]);
                    array_push($relationPrices, $relationPrice);
                }
                return $relationPrices;
            });
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case Partner::class:
                    throw new Exception('Partner not found', 404);
                    break;
                case FeeType::class:
                    throw new Exception('FeeType not found', 404);
                    break;
                case FeeRule::class:
                    throw new Exception('FeeRule not found', 404);
                    break;
                case Currency::class:
                    throw new Exception('Currency not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register RelationPrice', 500);
        }
    }

    private static function getPartnerById($id)
    {
        if ($id && $id != '') {
            return Partner::query()->findOrFail($id);
        }
        return null;
    }

    private static function getFeeTypeById($id)
    {
        if ($id && $id != '') {
            return FeeType::query()->findOrFail($id);
        }
        return null;
    }

    private static function getFeeRuleById($id)
    {
        if ($id && $id != '') {
            return FeeRule::query()->findOrFail($id);
        }
        return null;
    }

    private static function getCurrencyById($id)
    {
        if ($id && $id != '') {
            return Currency::query()->findOrFail($id);
        }
        return null;
    }
}
