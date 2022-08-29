<?php

namespace App\Services\Profile;

use App\Models\Profile;
use Exception;
use Illuminate\Support\Facades\Log;

class SearchToSelectProfileService
{
    public static function search($request)
    {
        try {
            $response =  Profile::query();
            if ($search = request()->search) {
                $response->where('name', 'ilike', "%$search%");
            }
            return $response->whereStatus('E')->select(['id as code', 'name as label'])->get();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Profile', 500);
        }
    }
}
