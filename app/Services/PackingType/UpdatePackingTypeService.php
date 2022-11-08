<?php

namespace App\Services\PackingType;

use App\Models\PackingType;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdatePackingTypeService
{
    public static function update($request, $packingTypeId)
    {
        try {
            $user = PackingType::query()->findOrFail($packingTypeId);
            $user->update(
                [
                    'name' => $request['name']
                ]
            );
            return $user->fresh();
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
            throw new Exception('Error to update PackingType', 500);
        }
    }
}
