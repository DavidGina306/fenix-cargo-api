<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DocType\SearchToSelectDocTypeService;
use Exception;
use Illuminate\Http\Request;

class DocTypeController extends Controller
{
    public function searchToSelect(Request $request)
    {
        try {
            return response(SearchToSelectDocTypeService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
