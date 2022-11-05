<?php

namespace App\Services\PackingType;

use App\Models\PackingType;
use Exception;
use Illuminate\Support\Facades\Log;

class SearchToSelectPackingTypeService
{
    public static function search($request)
    {
        try {
            $response =  PackingType::query();
            if ($search = $request->search) {
                $response->where('name', 'like', "%$search%")->orWhere('id', 'like', "%$search%");
            }
            return $response->whereStatus('E')->select(['id as code', 'name as label'])->get();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get PackingType', 500);
        }
    }
}
