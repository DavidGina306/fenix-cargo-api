<?php

namespace App\Http\Controllers\Api;

use App\DataTables\QuoteDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuoteRequest;
use App\Services\DatatableService;
use App\Services\Quote\StoreQuoteService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuoteController extends Controller
{
    private $quoteDataTable;

    public function __construct(QuoteDataTable $quoteDataTable)
    {
        $this->quoteDataTable = $quoteDataTable;
    }

    public function index()
    {
        return DatatableService::datatable($this->quoteDataTable);
    }

    public function store(StoreQuoteRequest $request)
    {
        try {
            DB::beginTransaction();
            $quote =  StoreQuoteService::store($request->all());
            DB::commit();
            return response($quote->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function calculate(StoreQuoteRequest $request)
    {
        try {
            DB::beginTransaction();
            $quote =  StoreQuoteService::store($request->all());
            DB::commit();
            return response($quote->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
