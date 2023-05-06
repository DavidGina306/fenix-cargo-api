<?php

namespace App\Http\Controllers\Api;

use App\DataTables\PartnerDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePartnerRequest;
use App\Http\Requests\UpdatePartnerRequest;
use App\Services\DatatableService;
use App\Services\Partner\GetPartnerService;
use App\Services\Partner\SearchToSelectPartnerService;
use App\Services\Partner\StorePartnerService;
use App\Services\Partner\UpdatePartnerService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartnerController extends Controller
{
    private $partnerDataTable;

    public function __construct(PartnerDataTable $partnerDataTable)
    {
        $this->partnerDataTable = $partnerDataTable;
    }

    public function index()
    {
        return DatatableService::datatable($this->partnerDataTable);
    }

    public function store(StorePartnerRequest $request)
    {
        try {
            DB::beginTransaction();
            $partner =  StorePartnerService::store($request->all());
            DB::commit();
            return response($partner->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function get($partner)
    {
        try {
            return response(GetPartnerService::get($partner), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function update(UpdatePartnerRequest $request, $partner)
    {
        try {
            DB::beginTransaction();
            $partner =  UpdatePartnerService::update($request->all(), $partner);
            DB::commit();
            return response($partner->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function searchToSelect(Request $request)
    {
        try {
            return response(SearchToSelectPartnerService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function groupSearchToSelect(Request $request)
    {
        try {
            return response(SearchToSelectPartnerService::groupSearchToSelect($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
