<?php

namespace App\Http\Controllers\Api;

use App\DataTables\DocTypeDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocTypeRequest;
use App\Http\Requests\UpdateDocTypeRequest;
use App\Services\DatatableService;
use App\Services\DocType\GetDocTypeService;
use App\Services\DocType\SearchToSelectDocTypeService;
use App\Services\DocType\StoreDocTypeService;
use App\Services\DocType\UpdateDocTypeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocTypeController extends Controller
{
    private $packingType;

    public function __construct(DocTypeDatatable $packingType)
    {
        $this->packingType = $packingType;
    }

    public function index()
    {
        return DatatableService::datatable($this->packingType);
    }

    public function searchToSelect(Request $request)
    {
        try {
            return response(SearchToSelectDocTypeService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function get($docTypeId)
    {
        try {
            $packingType =  GetDocTypeService::get($docTypeId);
            return response($packingType, 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function update(UpdateDocTypeRequest $request, $packingTypeId)
    {
        try {
            DB::beginTransaction();
            $Id =  UpdateDocTypeService::update($request->all(), $packingTypeId);
            DB::commit();
            return response($Id->toArray(), 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function store(StoreDocTypeRequest $request)
    {
        try {
            DB::beginTransaction();
            $packingType =  StoreDocTypeService::store($request->all());
            DB::commit();
            return response($packingType->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
