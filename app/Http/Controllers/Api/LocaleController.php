<?php

namespace App\Http\Controllers\Api;

use App\DataTables\LocaleDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\LocaleRequest;
use App\Http\Requests\UpdateLocaleRequest;
use App\Services\DatatableService;
use App\Services\FeeType\SearchToSelectLocaleService;
use App\Services\Locale\StoreLocaleService;
use App\Services\Locale\UpdateLocaleService;
use App\Services\PackingType\GetLocaleService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocaleController extends Controller
{
    private $localeDataTable;

    public function __construct(LocaleDataTable $localeDataTable)
    {
        $this->localeDataTable = $localeDataTable;
    }

    public function searchToSelect(Request $request)
    {
        try {
            return response(SearchToSelectLocaleService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function index()
    {
        return DatatableService::datatable($this->localeDataTable);
    }

    public function store(LocaleRequest $request)
    {
        try {
            DB::beginTransaction();
            $localeDataTable =  StoreLocaleService::store($request->all());
            DB::commit();
            return response($localeDataTable->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function get($packingTypeId)
    {
        try {
            $localeDataTable =  GetLocaleService::get($packingTypeId);
            return response($localeDataTable, 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function update(UpdateLocaleRequest $request, $locale)
    {
        try {
            DB::beginTransaction();
            $locale =  UpdateLocaleService::update($request->all(), $locale);
            DB::commit();
            return response($locale->toArray(), 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
