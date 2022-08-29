<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Currency\SearchToSelectCurrencyService;
use Exception;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function searchToSelect(Request $request)
    {
        try {
            return response(SearchToSelectCurrencyService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
