<?php

namespace App\Http\Controllers\Api;

use App\DataTables\CabinetDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCabinetRequest;
use App\Services\Cabinet\StoreCabinetService;
use App\Services\DatatableService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CabinetController extends Controller
{
    private $cabinetDataTable;

    public function __construct(CabinetDataTable $cabinetDataTable)
    {
        $this->cabinetDataTable = $cabinetDataTable;
    }

    public function index()
    {
        return DatatableService::datatable($this->cabinetDataTable);
    }

    public function store(StoreCabinetRequest $request)
    {
        try {
            DB::beginTransaction();
            $cabinet =  StoreCabinetService::store($request->all());
            DB::commit();
            return response($cabinet, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
