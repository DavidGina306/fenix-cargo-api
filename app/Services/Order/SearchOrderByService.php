<?php

namespace App\Services\Order;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class SearchOrderByService
{
    public static function searchOrderPaginate($request)
    {
        try {
            $response = Order::query();

            if ($orderId = $request->order) {
                $response->where('id', 'like', "%$orderId%");
            }

            if ($payerId = $request->customer) {
                $response->orWhere('payer_id', 'like', "%$payerId%");
            }


            return OrderResource::collection($response->paginate($request->per_page ?? 10));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Order', 500);
        }
    }
}
