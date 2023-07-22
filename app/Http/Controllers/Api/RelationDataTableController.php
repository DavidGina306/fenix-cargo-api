<?php

namespace App\Http\Controllers\Api;

use App\DataTables\RelationCompanyDataTable;
use App\DataTables\RelationFenixDataTable;
use App\DataTables\RelationPatnerDataTable;
use App\Http\Controllers\Controller;
use App\Services\DatatableService;

class RelationDataTableController extends Controller
{

    private $relationPatnerDatatable;
    private $relationCompanyDatatable;
    private $relationFenixDataTable;


    public function __construct(RelationPatnerDataTable $relationPatnerDatatable, RelationCompanyDataTable $relationCompanyDataTable, RelationFenixDataTable $relationFenixDataTable)
    {
        $this->relationPatnerDatatable = $relationPatnerDatatable;
        $this->relationCompanyDatatable = $relationCompanyDataTable;
        $this->relationFenixDataTable = $relationFenixDataTable;
    }


    public function getPatnerDataTable()
    {
        return DatatableService::datatable($this->relationPatnerDatatable);
    }

    public function getCompanyDataTable()
    {
        return DatatableService::datatable($this->relationCompanyDatatable);
    }


    public function getFenixDataTable()
    {
        return DatatableService::datatable($this->relationFenixDataTable);
    }
}
