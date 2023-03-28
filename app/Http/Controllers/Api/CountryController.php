<?php

namespace App\Http\Controllers\Api;

use App\DataTables\CountryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCountryRequest;
use App\Services\Country\SearchToSelecCountryService;
use App\Services\Country\StoreCountryService;
use App\Services\DatatableService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    private $countryDataTable;

    public function __construct(CountryDataTable $countryDataTable)
    {
        $this->countryDataTable = $countryDataTable;
    }

    public function index()
    {
        return DatatableService::datatable($this->countryDataTable);
    }

    public function searchToSelect(Request $request)
    {
        try {
            return response(SearchToSelecCountryService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function store(StoreCountryRequest $request)
    {
        try {
            DB::beginTransaction();
            $packingType =  StoreCountryService::store($request->all());
            DB::commit();
            return response($packingType->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
