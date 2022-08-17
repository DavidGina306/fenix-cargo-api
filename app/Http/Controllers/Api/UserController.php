<?php

namespace App\Http\Controllers\Api;

use App\DataTables\UserDatatable;
use App\Http\Controllers\Controller;
use App\Services\DatatableService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $userDatatable;

    public function __construct(UserDatatable $userDatatable)
    {
        $this->userDatatable = $userDatatable;
    }

    public function index()
    {
        return DatatableService::datatable($this->userDatatable);
    }


}
