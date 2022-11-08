<?php

namespace App\Http\Controllers\Api;

use App\DataTables\PackingTypeDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\PackingTypeRequest;
use App\Http\Requests\UpdatePackingTypeRequest;
use App\Services\DatatableService;
use App\Services\PackingType\GetPackingTypeService;
use App\Services\PackingType\SearchToSelectPackingTypeService;
use App\Services\PackingType\StorePackingTypeService;
use App\Services\PackingType\UpdatePackingTypeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackingTypeController extends Controller
{
    private $packingType;

    public function __construct(PackingTypeDatatable $packingType)
    {
        $this->packingType = $packingType;
    }

    public function searchToSelect(Request $request)
    {
        try {
            return response(SearchToSelectPackingTypeService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function index()
    {
        return DatatableService::datatable($this->packingType);
    }

    public function store(PackingTypeRequest $request)
    {
        try {
            DB::beginTransaction();
            $packingType =  StorePackingTypeService::store($request->all());
            DB::commit();
            return response($packingType->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function get($packingTypeId)
    {
        try {
            $packingType =  GetPackingTypeService::get($packingTypeId);
            return response($packingType, 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function update(UpdatePackingTypeRequest $request, $packingType)
    {
        try {
            DB::beginTransaction();
            $packingType =  UpdatePackingTypeService::update($request->all(), $packingType);
            DB::commit();
            return response($packingType->toArray(), 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

}
