<?php

namespace App\Services\Cabinet\Object;

use App\Helpers\MoneyToDecimal;
use App\Models\Cabinet;
use App\Models\ObjectModel;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class StoreObjectService
{
    public static function store(array $request, string $cabinetId): ObjectModel
    {
        try {
            $cabinet = Cabinet::query()->findOrFail($cabinetId);
            $object = ObjectModel::create(
                [
                    'width' => MoneyToDecimal::moneyToDecimal($request['width']),
                    'height' => MoneyToDecimal::moneyToDecimal($request['height']),
                    'length' => MoneyToDecimal::moneyToDecimal($request['length']),
                    'cubed_weight' => MoneyToDecimal::moneyToDecimal($request['weight']),
                    'quantity' =>$request['width'],
                    'cabinet_id' => $cabinet->id
                ]
            );
            return $object;
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Cabinet':
                    throw new Exception('Cabinet not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found in Object', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Object', 500);
        }
    }

    public static function storeAll(array $request, string $cabinetId)
    {
        try {
            foreach ($request as $value) {
                self::store($value, $cabinetId);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Object', 500);
        }
    }
}
