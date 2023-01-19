<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Cabinet\Object\PaginateObjectService;
use Exception;
use Illuminate\Http\Request;

class ObjectController extends Controller
{
    public function paginate(Request $request)
    {
        try {
            return PaginateObjectService::paginate($request);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
