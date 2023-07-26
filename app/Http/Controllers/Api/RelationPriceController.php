<?php

namespace App\Http\Controllers\Api;

use App\DataTables\RelationDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRelationPriceRequest;
use App\Services\DatatableService;
use App\Services\RelationPrice\GetRelationPriceService;
use App\Services\RelationPrice\StoreRelationPriceService;
use App\Services\RelationPrice\UpdatedRelationPriceService;
use Exception;
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

    public function update(StoreRelationPriceRequest $request, $relationPriceId)
    {
        try {
            DB::beginTransaction();
            $relationPrice =  UpdatedRelationPriceService::update($request->all(), $relationPriceId);
            DB::commit();
            return response($relationPrice, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }


    public function get($relationPrice)
    {
        try {
            DB::beginTransaction();
            $relationPrice =  GetRelationPriceService::get($relationPrice);
            DB::commit();
            return response($relationPrice, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }


    public function searchByType($type)
    {
        try {
            $relationPrices =  GetRelationPriceService::searchByType($type);
            return response($relationPrices, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

}
