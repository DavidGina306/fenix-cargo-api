<?php

namespace App\Http\Controllers\Api;

use App\DataTables\RelationCompanyDataTable;
use App\DataTables\RelationFenixDataTable;
use App\DataTables\RelationPatnerDataTable;
use App\DataTables\RelationPostCodeDataTable;
use App\Http\Controllers\Controller;
use App\Services\DatatableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RelationDataTableController extends Controller
{

    private $relationPatnerDatatable;
    private $relationCompanyDatatable;
    private $relationFenixDataTable;
    private $relationPostCodeDataTable;


    public function __construct(
        RelationPatnerDataTable $relationPatnerDatatable,
        RelationCompanyDataTable $relationCompanyDataTable,
        RelationFenixDataTable $relationFenixDataTable,
        RelationPostCodeDataTable $relationPostCodeDataTable
    ) {
        $this->relationPatnerDatatable = $relationPatnerDatatable;
        $this->relationCompanyDatatable = $relationCompanyDataTable;
        $this->relationFenixDataTable = $relationFenixDataTable;
        $this->relationPostCodeDataTable = $relationPostCodeDataTable;
    }


    public function getPatnerDataTable()
    {
        return DatatableService::datatable($this->relationPatnerDatatable);
    }

    public function getCompanyDataTable()
    {
        return DatatableService::datatable($this->relationCompanyDatatable);
    }


    public function getFenixDataTable(Request $request)
    {
        Log::warning([$request->research]);
        return DatatableService::datatable($this->relationFenixDataTable);
    }

    public function getPostcodeDataTable(Request $request)
    {
        return DatatableService::datatable($this->relationPostCodeDataTable);
    }
}
