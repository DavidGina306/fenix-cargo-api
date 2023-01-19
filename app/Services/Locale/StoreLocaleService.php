<?php

namespace App\Services\Locale;

use App\Models\Locale;
use Exception;
use Illuminate\Support\Facades\Log;

class StoreLocaleService
{
    public static function store($request)
    {
        try {
            $packingType = Locale::query()->firstOrCreate(
                [
                    'name' => $request['name']
                ]
            );
            return $packingType->fresh();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Locale', 500);
        }
    }
}
