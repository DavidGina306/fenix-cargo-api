<?php

namespace App\Services\Invoice;

use App\Models\Invoice;
use Exception;
use Illuminate\Support\Facades\Log;

class SearchToSelectInvoiceService
{
    public static function search($request)
    {
        try {
            $response =  Invoice::query();
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
            $response =  Invoice::query()->where('profile', 'like', "%$request->profile%");
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
