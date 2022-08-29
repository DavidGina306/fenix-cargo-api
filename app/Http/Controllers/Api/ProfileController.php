<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Profile\SearchToSelectProfileService;
use Exception;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function searchToSelect(Request $request)
    {
        try {
            return response(SearchToSelectProfileService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
