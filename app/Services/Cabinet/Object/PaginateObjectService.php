<?php

namespace App\Services\Cabinet\Object;

use App\Http\Resources\ObjectModelResource;
use App\Models\ObjectModel;
use Exception;
use Illuminate\Support\Facades\Log;

class PaginateObjectService
{
    public static function paginate($request)
    {
        try {
            $response = ObjectModel::query();

            if ($search = $request->search) {
                $response->whereHas('locale', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                })->orWhere('number', 'like', "%$search%")->orWhere('description', 'like', "%$search%")->where('current_quantity', '>', 0);
            }
            return ObjectModelResource::collection($response->paginate($request->per_page ?? 10));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get ObjectModel paginate', 500);
        }
    }

    public static function paginateCreate($request)
    {
        try {
            $response = ObjectModel::query();
            if ($request->customer && $request->locale) {
                $response->whereLocaleId($request->locale)->whereCustomerId($request->customer);
            }
            return ObjectModelResource::collection($response->paginate($request->per_page ?? 10));;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get  ObjectModel paginateCreate', 500);
        }
    }
}
