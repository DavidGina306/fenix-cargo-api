<?php

namespace App\Services\RelationPrice;

use App\Http\Resources\RelationPriceResource;
use App\Models\RelationPrice;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class GetRelationPriceService
{
    public static function get($relationPriceId)
    {
        try {
            $relationPrice = RelationPrice::query()->findOrFail($relationPriceId);
            return new RelationPriceResource($relationPrice);
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\relationPrice':
                    throw new Exception('RelationPrice not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get RelationPrice', 500);
        }
    }
}
