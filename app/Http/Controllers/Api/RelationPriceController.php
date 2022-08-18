<?php

namespace App\Http\Controllers\Api;

use App\DataTables\RelationDataTable;
use App\Http\Controllers\Controller;
use App\Services\DatatableService;
use Illuminate\Http\Request;

class RelationPriceController extends Controller
{
    private $userDatatable;

    public function __construct(RelationDataTable $userDatatable)
    {
        $this->userDatatable = $userDatatable;
    }

    public function index()
    {
        return DatatableService::datatable($this->userDatatable);
    }
}
