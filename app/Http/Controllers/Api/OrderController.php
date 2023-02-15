<?php

namespace App\Http\Controllers\Api;

use App\DataTables\OrderDatatables;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderSingleItemRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdatedOrderRequest;
use App\Services\DatatableService;
use App\Services\Order\SearchToSelectStatusOrderService;
use App\Services\Order\StoreOrderService;
use App\Services\Order\UpdateOrderService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    private $orderDataTable;

    public function __construct(OrderDatatables $orderDataTable)
    {
        $this->orderDataTable = $orderDataTable;
    }

    public function index()
    {
        return DatatableService::datatable($this->orderDataTable);
    }

    public function store(StoreOrderRequest $request)
    {
        try {
            DB::beginTransaction();
            $partner =  StoreOrderService::store($request->all());
            DB::commit();
            return response($partner->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function storeSingleItem(OrderSingleItemRequest $request)
    {
        try {
            DB::beginTransaction();
            $partner =  StoreOrderService::storeSingleItem($request->all());
            DB::commit();
            return response($partner->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function searchToSelectStatus(Request $request)
    {
        try {
            return response(SearchToSelectStatusOrderService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function updateMovement(UpdatedOrderRequest $request)
    {
        try {
            DB::beginTransaction();
            $partner =  UpdateOrderService::store($request->all());
            DB::commit();
            return response($partner->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
