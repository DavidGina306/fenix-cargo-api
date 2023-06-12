<?php

namespace App\Http\Controllers\Api;

use App\DataTables\InvoiceDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Services\DatatableService;
use App\Services\Invoice\GetInvoiceService;
use App\Services\Invoice\SearchToSelectInvoiceService;
use App\Services\Invoice\StoreInvoiceService;
use App\Services\Invoice\UpdateInvoiceService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    private $invoiceDatatable;

    public function __construct(InvoiceDatatable $invoiceDatatable)
    {
        $this->invoiceDatatable = $invoiceDatatable;
    }

    public function index()
    {
        return DatatableService::datatable($this->invoiceDatatable);
    }

    public function searchToSelect(Request $request)
    {
        try {
            return response(SearchToSelectInvoiceService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function get($InvoiceId)
    {
        try {
            $invoice =  GetInvoiceService::get($InvoiceId);
            return response($invoice, 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function update(UpdateInvoiceRequest $request, $invoiceId)
    {
        try {
            DB::beginTransaction();
            $Id =  UpdateInvoiceService::update($request->all(), $invoiceId);
            DB::commit();
            return response($Id->toArray(), 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function store(StoreInvoiceRequest $request)
    {
        try {
            DB::beginTransaction();
            $invoice =  StoreInvoiceService::store($request->all());
            DB::commit();
            return response($invoice->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
