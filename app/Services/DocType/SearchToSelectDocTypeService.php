<?php

namespace App\Services\DocType;

use App\Models\DocType;
use Exception;
use Illuminate\Support\Facades\Log;

class SearchToSelectDocTypeService
{
    public static function search($request)
    {
        try {
            $response =  DocType::query();
            if ($search = $request->search) {
                $response->where('name', 'like', "%$search%")->orWhere('id', 'like', "%$search%");
            }
            return $response->whereStatus('E')->select(['id as code', 'name as label'])->get();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get DocType', 500);
        }
    }
}
