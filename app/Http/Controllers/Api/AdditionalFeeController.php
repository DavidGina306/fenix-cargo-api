<?php

namespace App\Http\Controllers\Api;

use App\DataTables\AdditionalFeeDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdditionalFeeRequest;
use App\Http\Requests\UpdateAdditionalFeeRequest;
use App\Services\AdditionalFee\GetAdditionalFeeService;
use App\Services\AdditionalFee\SearchToSelectAdditionalFeeService;
use App\Services\AdditionalFee\StoreAdditionalFeeService;
use App\Services\AdditionalFee\UpdateAdditionalFeeService;
use App\Services\DatatableService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdditionalFeeController extends Controller
{
    private $additionalFee;

    public function __construct(AdditionalFeeDatatable $additionalFee)
    {
        $this->additionalFee = $additionalFee;
    }

    public function index()
    {
        return DatatableService::datatable($this->additionalFee);
    }

    public function searchToSelect(Request $request)
    {
        try {
            return response(SearchToSelectAdditionalFeeService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function getAdditionalFee($additionalFeeId)
    {
        try {
            return response(GetAdditionalFeeService::get($additionalFeeId), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function get($additionalFeeId)
    {
        try {
            return response(GetAdditionalFeeService::get($additionalFeeId), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }


    public function update(UpdateAdditionalFeeRequest $request, $packingTypeId)
    {
        try {
            DB::beginTransaction();
            $Id =  UpdateAdditionalFeeService::update($request->all(), $packingTypeId);
            DB::commit();
            return response($Id->toArray(), 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function store(StoreAdditionalFeeRequest $request)
    {
        try {
            DB::beginTransaction();
            $packingType =  StoreAdditionalFeeService::store($request->all());
            DB::commit();
            return response($packingType->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
