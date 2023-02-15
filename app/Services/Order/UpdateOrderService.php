<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\OrderMovement;
use App\Models\Status;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class UpdateOrderService
{
    public static function store($request)
    {
        try {
            $order = Order::query()->findOrFail($request['order_id']);
            $status = Status::query()->findOrFail($request['status_id']);

            $orderMovement = OrderMovement::create(
                [
                    'status_id' => $status->id,
                    'order_id' => $order->id,
                    'entry_date' => isset($request['entry_date']) ? new Carbon($request['entry_date']) : Carbon::now(),
                    'received_for' => $request['received_for'],
                    'doc_received_for' => $request['doc_received_for'],
                ]
            );
            return $orderMovement;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Order', 500);
        }
    }
}
