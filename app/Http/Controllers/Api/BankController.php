<?php

namespace App\Http\Controllers\Api;

use App\DataTables\BankDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\BankRequest;
use App\Services\Bank\SearchToSelectBankService;
use App\Services\Bank\StoreBankService;
use App\Services\DatatableService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BankController extends Controller
{
    private $bankDataTable;

    public function __construct(BankDataTable $bankDataTable)
    {
        $this->bankDataTable = $bankDataTable;
    }

    public function index()
    {
        return DatatableService::datatable($this->bankDataTable);
    }

    public function searchToSelect(Request $request)
    {
        try {
            return response(SearchToSelectBankService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function store(BankRequest $request)
    {
        try {
            DB::beginTransaction();
            $packingType =  StoreBankService::store($request->all());
            DB::commit();
            return response($packingType->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

}
