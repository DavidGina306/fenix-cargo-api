<?php

namespace App\Services\PackingType;

use App\Http\Resources\PackingTypeResource;
use App\Models\PackingType;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class GetPackingTypeService
{
    public static function get($packingTypeId)
    {
        try {
            $packingType = PackingType::query()->findOrFail($packingTypeId);
            return new PackingTypeResource($packingType);
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\PackingType':
                    throw new Exception('PackingType not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get PackingType', 500);
        }
    }
}
