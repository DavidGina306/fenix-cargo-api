<?php

namespace App\Services\Cabinet\Object;

use App\Models\Cabinet;
use App\Models\Locale;
use App\Models\Media;
use App\Models\ObjectModel;
use App\Services\StoreMediasService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class StoreObjectService
{
    public static function store(array $request, string $cabinetId, string $customerId, string $addressId): ObjectModel
    {
        try {
            $cabinet = Cabinet::query()->findOrFail($cabinetId);
            $locale = Locale::query()->findOrFail($request['locale_id']);
            $object = ObjectModel::create(
                [
                    'number' => $request['number'],
                    'position' => $request['position'] ?? '',
                    'width' => $width = number_format($request['width'], 2, '.', ' '),
                    'height' => $height = number_format($request['height'], 2, '.', ' '),
                    'length' => $length = number_format($request['length'], 2, '.', ' '),
                    'weight' => number_format($request['weight'], 2, '.', ' '),
                    'cubed_metric' => number_format(($length * $width * $height / 1000000), 2, '.', ' '),
                    'cubed_weight' =>  number_format($length * $width * $height  / 6000, 2, '.', ' '),
                    'description' =>  $request['description'],
                    'quantity' => $request['quantity'],
                    'cabinet_id' => $cabinet->id,
                    'locale_id' => $locale->id,
                    'customer_id' => $customerId,
                    'address_id' => $addressId,
                    'current_quantity' => $request['quantity']
                ]
            );
            Log::warning($request['files']);
            self::storeImages($request['files'], $object->id);
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

    public static function storeAll(array $request, string $cabinetId, string $customerId, string $addressId)
    {
        try {
            foreach ($request as $value) {
                self::store($value, $cabinetId, $customerId, $addressId);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Object', 500);
        }
    }


    public static function storeImages(array $data, string $objectId)
    {
        try {
            foreach ($data as $value) {
                $image = StoreMediasService::store($value);
                Media::query()->firstOrCreate(
                    [
                        "mediable_id" => $objectId,
                        "mediable_type" => ObjectModel::class,
                        "url" => $image
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register images to Object', 500);
        }
    }
}
