<?php

namespace App\Services\Locale;

use App\Models\Locale;
use Exception;
use Illuminate\Support\Facades\Log;

class SearchToSelectLocaleService
{
    public static function search($request)
    {
        try {
            $response =  Locale::query();
            if ($search = $request->search) {
                $response->where('name', 'like', "%$search%")->orWhere('id', 'like', "%$search%");
            }
            return $response->whereStatus('E')->select(['id as code', 'name as label'])->get();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Locale', 500);
        }
    }
}
