<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PriceType\SearchToSelectPriceTypeService;
use Exception;
use Illuminate\Http\Request;

class PartnerAgentController extends Controller
{
    public function searchToSelect(Request $request)
    {
        try {
            return response(SearchToSelectPriceTypeService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
