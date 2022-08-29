<?php

namespace App\Services\RelationPrice;

use App\Helpers\MoneyToDecimal;
use App\Models\Currency;
use App\Models\FeeRule;
use App\Models\RelationPrice;
use App\Models\RelationPriceDetail;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class StoreDetailsRelationService
{
    public static function store($data, RelationPrice $relationPrice): array
    {
        try {
            $dataValues = [];
            foreach ($data as $rule) {
                $currency = Currency::query()->findOrFail($rule['currency_id']);
                $feeRule = FeeRule::query()->findOrFail($rule['fee_rule_id']);
                array_push($dataValues, RelationPriceDetail::query()->create(
                    [
                        'value' => MoneyToDecimal::moneyToDecimal($rule['value']),
                        'weight_initial' => MoneyToDecimal::moneyToDecimal($rule['weight_initial']),
                        'weight_final' =>  MoneyToDecimal::moneyToDecimal($rule['weight_final']) ?? "",
                        'currency_id' => $currency->id,
                        'relation_price_id' => $relationPrice->id,
                        'fee_rule_id' => $feeRule->id
                    ]
                ));
            }
            return $dataValues;
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Currency':
                    throw new Exception('Currency not found', 404);
                    break;
                case 'App\Models\FeeRule':
                    throw new Exception('FeeRule not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Relation Price Detail', 500);
        }
    }
}
