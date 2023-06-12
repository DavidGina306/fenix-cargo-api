<?php

namespace App\Services\Cabinet\Object;

use App\Models\ObjectModel;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SearchToSelectObjectService
{
    public static function search($request)
    {
        try {
            $response =  ObjectModel::query();
            if ($search = $request->search) {
                $response->where('name', 'like', "%$search%")->orWhere('id', 'like', "%$search%");
            }
            return $response->select(['id as code', DB::raw("CONCAT(number, ' - ', description) as label")])->get();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Profile', 500);
        }
    }
}
