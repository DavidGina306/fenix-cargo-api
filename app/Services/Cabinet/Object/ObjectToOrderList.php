<?php

namespace App\Services\Cabinet\Object;

use App\Http\Resources\ObjectToOrderResource;
use App\Models\ObjectModel;
use Exception;
use Illuminate\Support\Facades\Log;

class ObjectToOrderList
{
    public static function paginate($request)
    {
        try {
            $response = ObjectModel::query();

            if ($search = $request->search) {
                $response->whereHas('locale', function($q) use($search) {
                    $q->where('name', 'like', "%$search%");
                })->orWhere('number', 'like', "%$search%");
            }
            return ObjectToOrderResource::collection($response->paginate($request->per_page ?? 10));
        }  catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register ObjectModel', 500);
        }
    }
}
