<?php

namespace App\Services\RelationPrice;

use App\Enums\RelationPriceType;
use App\Helpers\MoneyToDecimal;
use App\Models\FeeRule;
use App\Models\FeeType;
use App\Models\Partner;
use App\Models\RelationPrice;
use App\Services\Country\GetCountryService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class StoreRelationPriceService
{
    /**
     * Function created to register RelationPrice
     *
     * @param array $request
     * @return RelationPrice
     */
    public static function store(array $request)
    {
        try {
            $relationPrices = [];
            foreach ($request['rule_types'] as $rule) {
                if (isset($request['partner_id']) && $request['partner_id'] != '') {
                    $partner = Partner::query()->findOrFail($request['partner_id']);
                }
                if (isset($request['fee_type_id']) && $request['fee_type_id'] != '') {
                    $feeType = FeeType::query()->findOrFail($request['fee_type_id']);
                }
                if(isset($request['fee_rule_id']) && $request['fee_type_id'] != '') {
                    $feeRule = FeeRule::query()->findOrFail($request['fee_rule_id']);
                }
                $relationPrice = RelationPrice::query()->firstOrCreate([
                    'number' => substr(str_shuffle(time() . mt_rand(0, 999) . md5(time() . mt_rand(0, 999))), 0, 16),
                    'destiny_1' => $request['destiny_1'],
                    'destiny_2' => $request['destiny_2'],
                    'type' => $request['type'] == 'P' ? RelationPriceType::PATERN : $request['type'] == 'C' ? RelationPriceType::COMPANY : RelationPriceType::FENIX,
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
                    'fee_type_id' => isset($feeType) ? $feeType->id : null
                ]);
                array_push($relationPrices, $relationPrice);
            }

            //StoreDetailsRelationService::store($request['rule_types'],  $relationPrice);
            return  $relationPrices;
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Partner':
                    throw new Exception('Partner not found', 404);
                    break;
                case 'App\Models\Partner':
                        throw new Exception('FeeType not found', 404);
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
