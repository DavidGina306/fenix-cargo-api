<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AdditionalFee\SearchToSelectAdditionalFeeService;
use Exception;
use Illuminate\Http\Request;

class AdditionalFeeController extends Controller
{
    public function searchToSelect(Request $request)
    {
        try {
            return response(SearchToSelectAdditionalFeeService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
