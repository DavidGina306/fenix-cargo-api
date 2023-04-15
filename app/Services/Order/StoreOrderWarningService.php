<?php

namespace App\Services\Order;

use App\Helpers\MoneyToDecimal;
use App\Models\Order;
use App\Models\OrderWarning;
use App\Models\Partner;
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
                    'contact' => isset($request['contact']) ? $request['contact'] : "",
                    'value' => MoneyToDecimal::moneyToDecimal($request['value']),
                ]
            );
            return $warning;
        } catch (\Exception $e) {
            Log::error($e);
            throw new Exception('Error to register Order Warning', 500);
        }
    }
}
