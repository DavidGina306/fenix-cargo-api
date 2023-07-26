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
use Illuminate\Support\Facades\Log;

class UpdatedRelationPriceService
{
    /**
     * Function created to register RelationPrice
     *
     * @param array $request
     * @return RelationPrice
     */
    public static function update(array $request, $relationPriceId)
    {
        try {
            $relationPrices = [];
            $relationPrice = RelationPrice::query()->findOrFail($relationPriceId);
            foreach ($request['rule_types'] as $rule) {
                if (isset($request['partner_id']) && $request['partner_id'] != '') {
                    $partner = Partner::query()->findOrFail($request['partner_id']);
                }
                if (isset($request['fee_type_id']) && $request['fee_type_id'] != '') {
                    $feeType = FeeType::query()->findOrFail($request['fee_type_id']);
                }
                if(isset($rule['fee_rule_id']) && $rule['fee_rule_id'] != '') {
                    $feeRule = FeeRule::query()->findOrFail($rule['fee_rule_id']);
                }

                if(isset($rule['currency_id']) && $rule['currency_id'] != '' ) {
                    $currency = Currency::query()->findOrFail($rule['currency_id']);
                }
                $relationPrice->update([
                    'number' => substr(str_shuffle(time() . mt_rand(0, 999) . md5(time() . mt_rand(0, 999))), 0, 16),
                    'destiny_1' => $request['destiny_1'],
                    'destiny_2' => $request['destiny_2'],
                    'type' => $request['type'] == 'P' ? RelationPriceType::PARTNER : $request['type'] == 'C' ? RelationPriceType::COMPANY : RelationPriceType::FENIX,
                    "destiny_country"=> GetCountryService::searchById($request['destiny_country'])->id,
                    "local_type" => $request['local_type'] ?? false,
                    'origin_city' => $request['origin_city'],
                    'origin_country' => GetCountryService::searchById($request['origin_country'])->id,
                    'origin_state' => $request['origin_state'],
                    'deadline_type' => $request['deadline_type'],
                    'deadline_initial' => $request['deadline_initial'],
                    'deadline_final' => $request['deadline_final'] ?? "",
                    'value' => MoneyToDecimal::moneyToDecimal($rule['value']),
                    'weight_initial' => MoneyToDecimal::moneyToDecimal($rule['weight_initial']),
                    'weight_final' =>  MoneyToDecimal::moneyToDecimal($rule['weight_final']) ?? "",
                    'fee_rule_id' => isset($feeRule) ? $feeRule->id : null,
                    'partner_id' =>  isset($partner) ? $partner->id : null,
                    'fee_type_id' => isset($feeType) ? $feeType->id : null,
                    'currency_id' => isset($currency) ? $currency->id : null,
                ]);
            }
            return  $relationPrices;
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\RelationPrice':
                    throw new Exception('RelationPrice not found', 404);
                    break;
                case 'App\Models\Partner':
                    throw new Exception('Partner not found', 404);
                    break;
                case 'App\Models\FeeType':
                        throw new Exception('FeeType not found', 404);
                        break;
                case 'App\Models\FeeRule':
                        throw new Exception('FeeRule not found', 404);
                        break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register RelationPrice', 500);
        }
    }
}
