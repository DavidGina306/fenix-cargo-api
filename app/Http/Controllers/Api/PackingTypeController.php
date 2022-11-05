<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PackingType\SearchToSelectPackingTypeService;
use Exception;
use Illuminate\Http\Request;

class PackingTypeController extends Controller
{
    public function searchToSelect(Request $request)
    {
        try {
            return response(SearchToSelectPackingTypeService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
