<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\OrderMovement;
use App\Models\Status;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
                    'time' => $request['time'],
                    'entry_date' => isset($request['entry_date']) ? new Carbon($request['entry_date']) : Carbon::now(),
                    'received_for' => $request['received_for'],
                    'doc_received_for' => $request['doc_received_for'],
                    'document_type' => $request['document_type'],
                    'locale' => self::setLocale($order, $request)
                ]
            );
            $order->update(['status_id' => $status->id]);
            return $orderMovement;
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Order':
                    throw new Exception('Order not found', 404);
                    break;
                case 'App\Models\Status':
                    throw new Exception('Status not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Order', 500);
        }
    }
    /**
     * funtion to get city
     *
     * @param Order $order
     * @param array $request
     * @return string
     */
    public static function setLocale(Order $order, array $request): string
    {
        try {
            Log::info($order);
            if ($request['city'] == 'O') {
                return $order->address->town;
            } else if ($request['city'] == 'D') {
                return $order->address->town;
            }
            return $request['other_city'];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register set Locale', 500);
        }
    }
}
