<?php

namespace App\Http\Controllers\Api;

use App\DataTables\OrderDatatables;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderSingleItemRequest;
use App\Http\Requests\StoreOrderMovementRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\StoreOrderWarningRequest;
use App\Http\Requests\UpdatedOrderRequest;
use App\Http\Requests\UpdateMovementItemRequest;
use App\Services\DatatableService;
use App\Services\Order\GetOrderService;
use App\Services\Order\Movement\ListMovementOrderService;
use App\Services\Order\Movement\ListOrderWarningService;
use App\Services\Order\Movement\StoreOrderMovementService;
use App\Services\Order\Movement\UpdateMovementService;
use App\Services\Order\SearchToSelectStatusOrderService;
use App\Services\Order\StoreOrderService;
use App\Services\Order\StoreOrderWarningService;
use App\Services\Order\UpdateOrderService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            $order =  StoreOrderService::store($request->all());
            DB::commit();
            return response($order->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function storeSingleItem(OrderSingleItemRequest $request)
    {
        try {
            DB::beginTransaction();
            $order =  StoreOrderService::storeSingleItem($request->all());
            DB::commit();
            return response($order->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function listMovement($orderId)
    {
        try {
            return response(ListMovementOrderService::listOrderMovements($orderId), 200);
        } catch (\Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function listWarnings($orderId)
    {
        try {
            return response(ListOrderWarningService::listWarningOrder($orderId), 200);
        } catch (\Exception $e) {
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

    public function update(UpdatedOrderRequest $request, $orderId)
    {
        try {
            DB::beginTransaction();
            $order =  UpdateOrderService::update($request->all(), $orderId);
            DB::commit();
            return response($order->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function updateMovement(UpdateMovementItemRequest $request)
    {
        try {
            DB::beginTransaction();
            $orderMovement =  UpdateMovementService::update($request->all());
            DB::commit();
            return response($orderMovement->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function storeOrderWarning(StoreOrderWarningRequest $request)
    {
        try {
            DB::beginTransaction();
            $orderWarning =  StoreOrderWarningService::store($request->all());
            DB::commit();
            return response($orderWarning->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function storeOrderMovement(StoreOrderMovementRequest $request)
    {
        try {
            DB::beginTransaction();
            $orderWarning =  StoreOrderMovementService::store($request->all());
            DB::commit();
            return response($orderWarning->toArray(), 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }


    public function getData($orderId)
    {
        try {
            DB::beginTransaction();
            $order =  GetOrderService::get($orderId);
            DB::commit();
            return response($order, 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
