<?php

namespace App\Services\Order;

use App\Models\Status;
use Exception;
use Illuminate\Support\Facades\Log;

class SearchToSelectStatusOrderService
{
    public static function search($request)
    {
        try {
            $response =  Status::query()->where('group', 'order');
            if ($search = $request->search) {
                $response->where('name', 'like', "%$search%");
            }
            return $response->select(['id as code', 'name as label'])->get();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Locale', 500);
        }
    }
}
