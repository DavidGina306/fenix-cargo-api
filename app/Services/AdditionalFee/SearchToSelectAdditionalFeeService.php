<?php

namespace App\Services\AdditionalFee;

use App\Models\AdditionalFee;
use Exception;
use Illuminate\Support\Facades\Log;

class SearchToSelectAdditionalFeeService
{
    public static function search($request)
    {
        try {
            $response =  AdditionalFee::query();
            if ($search = $request->search) {
                $response->where('name', 'like', "%$search%")->orWhere('id', 'like', "%$search%");
            }
            return $response->whereStatus('E')->select(['id as code', 'name as label', 'value as value'])->get();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get AdditionalFee', 500);
        }
    }
}
