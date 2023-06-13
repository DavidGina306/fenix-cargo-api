<?php

namespace App\Services\Order;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Status;
use Exception;
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

            $response->where('status_id', '<>', Status::query()->where('group', 'order')->where('letter', 'F')->first()->id);
            return OrderResource::collection($response->paginate($request->per_page ?? 10));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Order', 500);
        }
    }
}
