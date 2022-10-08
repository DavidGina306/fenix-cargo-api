<?php

namespace App\Services\Currency;

use App\Models\Currency;
use Exception;
use Illuminate\Support\Facades\Log;

class SearchToSelectCurrencyService
{
    public static function search($request)
    {
        try {
            $response =  Currency::query();
            if ($search = $request->search) {
                $response->where('name', 'like', "%$search%")->orWhere('id', 'like', "%$search%");
            }
            return $response->whereStatus('E')->select(['id as code', 'name as label'])->get();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Profile', 500);
        }
    }
}
