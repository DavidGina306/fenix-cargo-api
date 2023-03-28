<?php

namespace App\Services\Order;

use App\Helpers\MoneyToDecimal;
use App\Models\Order;
use App\Models\OrderWarning;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class StoreOrderWarningService
{
    public static function store($request)
    {
        try {
            $order = Order::query()->findOrFail($request['order_id']);

            $warning = OrderWarning::create(
                [
                    'order_id' => $order->id,
                    'responsible' => $request['responsible'],
                    'entry_date' => isset($request['entry_date']) ? new Carbon($request['entry_date']) : Carbon::now(),
                    'notes' => $request['note'],
                    'value' => MoneyToDecimal::moneyToDecimal($request['value']),
                    'agent' => $request['agent'],
                ]
            );
            return $warning;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Order Warning', 500);
        }
    }
}
