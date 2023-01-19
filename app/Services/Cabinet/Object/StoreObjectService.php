<?php

namespace App\Services\Cabinet\Object;

use App\Helpers\MoneyToDecimal;
use App\Models\Cabinet;
use App\Models\Locale;
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
            $locale = Locale::query()->findOrFail($request['locale_id']);
            $object = ObjectModel::create(
                [
                    'number' => substr(str_shuffle(time() . mt_rand(0, 999) . md5(time() . mt_rand(0, 999))), 0, 16),
                    'width' => $width = MoneyToDecimal::moneyToDecimal($request['width']),
                    'height' => $height = MoneyToDecimal::moneyToDecimal($request['height']),
                    'length' => $length = MoneyToDecimal::moneyToDecimal($request['length']),
                    'weight' => MoneyToDecimal::moneyToDecimal($request['weight']),
                    'cubed_metric' => $length * $width * $height,
                    'cubed_weight' =>  ($length * $width * $height) / 6000,
                    'description' =>  $request['description'],
                    'quantity' => $request['quantity'],
                    'cabinet_id' => $cabinet->id,
                    'locale_id' => $locale->id,
                ]
            );
            return $object;
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Cabinet':
                    throw new Exception('Cabinet not found', 404);
                    break;
                case 'App\Models\Locale':
                    throw new Exception('Locale not found', 404);
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
