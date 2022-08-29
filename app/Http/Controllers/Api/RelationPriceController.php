<?php

namespace App\Http\Controllers\Api;

use App\DataTables\RelationDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRelationPriceRequest;
use App\Services\DatatableService;
use App\Services\RelationPrice\StoreRelationPriceService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RelationPriceController extends Controller
{
    private $userDatatable;

    public function __construct(RelationDataTable $userDatatable)
    {
        $this->userDatatable = $userDatatable;
    }

    public function index()
    {
        return DatatableService::datatable($this->userDatatable);
    }

    public function store(StoreRelationPriceRequest $request)
    {
        try {
            DB::beginTransaction();
            $relationPrice =  StoreRelationPriceService::store($request->all());
            DB::commit();
            return response($relationPrice, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
