<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FeeType\SearchToSelectFeeTypeService;
use Exception;
use Illuminate\Http\Request;

class FeeTypeController extends Controller
{
    public function searchToSelect(Request $request)
    {
        try {
            return response(SearchToSelectFeeTypeService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
