<?php

namespace App\Services\Order;

use App\Helpers\MoneyToDecimal;
use App\Models\Media;
use App\Models\OrderWarning;
use App\Services\StoreMediasService;
use Exception;
use Illuminate\Support\Facades\Log;

class UpdateOrderWarningService
{
    public static function update($request)
    {
        try {
            $warning = OrderWarning::query()->findOrFail($request['id']);

            $warning->update(
                [
                    'contact' => isset($request['contact']) ? $request['contact'] : isset($request['number']),
                    'value' => MoneyToDecimal::moneyToDecimal($request['value']),
                ]
            );
            if(isset($request['files'])) {
                self::storeImages($request['files'], $warning->id);
            }
            return $warning;
        } catch (\Exception $e) {
            Log::error($e);
            throw new Exception('Error to register Order Warning', 500);
        }
    }

    public static function storeImages(array $data, string $orderWaningId)
    {
        try {
            foreach ($data as $value) {
                $image = StoreMediasService::store($value);
                Media::query()->firstOrCreate(
                    [
                        "mediable_id" => $orderWaningId,
                        "mediable_type" => OrderWarning::class,
                        "url" => $image
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register images to Order Warnings', 500);
        }
    }
}
