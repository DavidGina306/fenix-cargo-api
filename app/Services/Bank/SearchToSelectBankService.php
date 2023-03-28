<?php

namespace App\Services\Bank;

use App\Models\Bank;
use Exception;
use Illuminate\Support\Facades\Log;

class SearchToSelectBankService
{
    public static function search($request)
    {
        try {
            $response =  Bank::query();
            if ($search = $request->search) {
                $response->where('name', 'like', "%$search%")->orWhere('id', 'like', "%$search%");
            }
            return $response->select(['id as code', 'name as label'])->get();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Bank', 500);
        }
    }
}
