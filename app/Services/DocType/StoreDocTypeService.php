<?php

namespace App\Services\DocType;

use App\Models\DocType;
use Exception;
use Illuminate\Support\Facades\Log;

class StoreDocTypeService
{
    public static function store($request)
    {
        try {
            $packingType = DocType::query()->firstOrCreate(
                [
                    'name' => $request['name']
                ]
            );
            return $packingType->fresh();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register DocType', 500);
        }
    }
}
