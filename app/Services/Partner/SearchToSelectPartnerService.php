<?php

namespace App\Services\Partner;

use App\Models\Partner;
use Exception;
use Illuminate\Support\Facades\Log;

class SearchToSelectPartnerService
{
    public static function search($request)
    {
        try {
            $response =  Partner::query();
            if ($search = $request->search) {
                $response->where('name', 'like', "%$search%")->orWhere('id', 'like', "%$search%");
            }
            return $response->whereStatus('E')->select(['id as code', 'name as label'])->get();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Profile', 500);
        }
    }

    public static function groupSearchToSelect($request)
    {
        try {
            Log::warning($request->profile);
            $response =  Partner::query()->where('profile', 'like', "%$request->profile%");
            if ($search = $request->search) {
                $response->where('name', 'like', "%$search%");
            }
            return $response->whereStatus('E')->select(['id as code', 'name as label'])->get();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Customer', 500);
        }
    }
}
