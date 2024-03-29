<?php

namespace App\Services\Order\Movement;

use App\Http\Resources\ListOrderWarningToEditResource;
use App\Models\Order;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class ListOrderWarningService
{
    public static function listWarningOrder($orderId)
    {
        try {
            $order = Order::query()->findOrFail($orderId);
            return new ListOrderWarningToEditResource($order);
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Order':
                    throw new Exception('Order not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to update Status Customer', 500);
        }
    }
}
