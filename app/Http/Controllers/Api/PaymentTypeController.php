<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PaymentType\SearchToSelectPaymentTypeService;
use Exception;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    public function searchToSelect(Request $request)
    {
        try {
            return response(SearchToSelectPaymentTypeService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
