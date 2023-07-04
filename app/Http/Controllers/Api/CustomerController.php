<?php

namespace App\Http\Controllers\Api;

use App\DataTables\CustomerDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Services\Customer\ChangeStatusCustomerService;
use App\Services\Customer\GetCustomerService;
use App\Services\Customer\SearchToSelectCustomerService;
use App\Services\Customer\StoreCustomerService;
use App\Services\DatatableService;
use App\Services\Customer\UpdateCustomerService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    private $customerDataTable;

    public function __construct(CustomerDataTable $customerDataTable)
    {
        $this->customerDataTable = $customerDataTable;
    }

    public function index()
    {
        return DatatableService::datatable($this->customerDataTable);
    }

    public function store(StoreCustomerRequest $request)
    {
        try {
            DB::beginTransaction();
            $customer =  StoreCustomerService::store($request->all());
            DB::commit();
            return response($customer->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function update(UpdateCustomerRequest $request, $customer)
    {
        try {
            DB::beginTransaction();
            $customer =  UpdateCustomerService::update($request->all(), $customer);
            DB::commit();
            return response($customer->toArray(), 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function get($customer)
    {
        try {
            $customer =  GetCustomerService::get($customer);
            return response($customer, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function changeStatus($customer)
    {
        try {
            DB::beginTransaction();
            $customer =  ChangeStatusCustomerService::changeStatus($customer);
            DB::commit();
            return response($customer, 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function searchToSelect(Request $request)
    {
        try {
            return response(SearchToSelectCustomerService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
