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
                $response->whereHas('locale', function($q) use($search) {
                    $q->where('name', 'like', "%$search%");
                })->orWhere('order', 'like', "%$search%");
            }
            return ObjectModelResource::collection($response->paginate($request->per_page ?? 10));
        }  catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register ObjectModel', 500);
        }
    }
}
