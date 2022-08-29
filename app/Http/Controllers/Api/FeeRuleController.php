<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FeeRule\SearchToSelectFeeRuleService;
use Exception;
use Illuminate\Http\Request;

class FeeRuleController extends Controller
{
    public function searchToSelect(Request $request)
    {
        try {
            return response(SearchToSelectFeeRuleService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
