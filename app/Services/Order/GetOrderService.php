<?php

namespace App\Services\Order;

use App\Http\Resources\EditOrderResource;
use App\Models\Order;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class GetOrderService
{
    public static function get($orderId)
    {
        try {
            $order = Order::query()->findOrFail($orderId);
            return new EditOrderResource($order);
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Order':
                    throw new Exception('Order not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Order', 500);
        }
    }
}
