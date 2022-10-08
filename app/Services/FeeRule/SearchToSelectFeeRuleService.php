<?php

namespace App\Services\FeeRule;

use App\Models\FeeRule;
use Exception;
use Illuminate\Support\Facades\Log;

class SearchToSelectFeeRuleService
{
    public static function search($request)
    {
        try {
            $response =  FeeRule::query();
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
