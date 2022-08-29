<?php

namespace App\Services\RelationPrice;

use App\Models\FeeType;
use App\Services\Address\StoreAddressService;
use App\Services\Partner\Agent\StoreAgentService;
use App\Models\Partner;
use App\Models\RelationPrice;
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
    public static function store(array $request): RelationPrice
    {
        try {
            if (isset($request['partner_id']) && $request['partner_id'] != '') {
                $partner = Partner::query()->findOrFail($request['partner_id']);
            }
            $feeType = FeeType::query()->findOrFail($request['fee_type_id']);
            $relationPrice = RelationPrice::query()->firstOrCreate([
                'number' => substr(str_shuffle(time() . mt_rand(0, 999) . md5(time() . mt_rand(0, 999))), 0, 16),
                'destiny_type' => $request['destiny_type'],
                'destiny_initial' => $request['destiny_initial'],
                'destiny_final' => $request['destiny_final'] ?? "",
                'destiny_state' => $request['destiny_state'],
                'origin_type' => $request['origin_type'],
                'origin_initial' => $request['origin_initial'],
                'origin_state' => $request['origin_state'],
                'deadline_type' => $request['deadline_type'],
                'deadline_initial' => $request['deadline_initial'],
                'deadline_final' => $request['deadline_final'] ?? "",
                'partner_id' =>  isset($partner) ? $partner->id : null,
                'fee_type_id' => $feeType->id
            ]);
            StoreDetailsRelationService::store($request['rule_types'],  $relationPrice);
            return  $relationPrice;
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Partner':
                    throw new Exception('Partner not found', 404);
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
