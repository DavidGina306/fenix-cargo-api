<?php

namespace App\Http\Controllers\Api;

use App\DataTables\UserDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Services\DatatableService;
use App\Services\User\StoreUserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user =  StoreUserService::store($request->all());
            DB::commit();
            return response($user->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }


}
