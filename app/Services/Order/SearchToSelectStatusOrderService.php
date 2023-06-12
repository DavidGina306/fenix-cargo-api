<?php

namespace App\Services\Order;

use App\Models\Order;
use App\Models\Status;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SearchToSelectStatusOrderService
{
    public static function search($request)
    {
        try {
            $response =  Status::query()->where('group', 'order');
            if ($search = $request->search) {
                $response->where('number', 'like', "%$search%");
            }
            return $response->select(['id as code', 'name as label'])->get();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Order', 500);
        }
    }


    public static function searchByNumber($request)
    {
        try {
            $response =  Order::query();
            if ($search = $request->search) {
                $response->where('number', 'like', "%$search%");
            }
            return $response->select(['id as code', 'number as label'])->get();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Order', 500);
        }
    }
}
