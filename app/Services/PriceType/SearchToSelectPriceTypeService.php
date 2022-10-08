<?php

namespace App\Services\PriceType;

use App\Models\PriceType;
use Exception;
use Illuminate\Support\Facades\Log;

class SearchToSelectPriceTypeService
{
    public static function search($request)
    {
        try {
            $response =  PriceType::query();
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
