<?php

namespace App\Services\Order;

use App\Helpers\MoneyToDecimal;
use App\Models\Media;
use App\Models\Order;
use App\Models\OrderWarning;
use App\Models\Partner;
use App\Services\StoreMediasService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class StoreOrderWarningService
{
    public static function store($request)
    {
        try {
            $order = Order::query()->findOrFail($request['order_id']);
            $partner = Partner::query()->findOrFail($request['partner_id']);

            $warning = OrderWarning::create(
                [
                    'profile' => $request['profile'],
                    'order_id' => $order->id,
                    'partner_id' => $partner->id,
                    'entry_date' => isset($request['entry_date']) ? new Carbon($request['entry_date']) : Carbon::now(),
                    'contact' => isset($request['contact']) ? $request['contact'] : isset($request['number']),
                    'value' => MoneyToDecimal::moneyToDecimal($request['value']),
                ]
            );
            self::storeImages($request['files'], $warning->id);
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
