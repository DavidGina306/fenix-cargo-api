<?php

namespace App\Services\Country;

use App\Models\Country;
use Exception;
use Illuminate\Support\Facades\Log;

class GetCountryService
{
    public static function searchById($uuid)
    {
        try {
            return Country::query()->findOrFail($uuid);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Country', 500);
        }
    }
}
