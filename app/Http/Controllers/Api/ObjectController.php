<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ObejctoToOrderRequest;
use App\Models\ObjectModel;
use App\Services\Cabinet\Object\PaginateObjectService;
use App\Services\Cabinet\Object\SearchToSelectObjectService;
use App\Services\Cabinet\Object\StoreObectToOrderService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use QrCode;
class ObjectController extends Controller
{
    public function paginate(Request $request)
    {
        try {
            return PaginateObjectService::paginate($request);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function searchToSelect(Request $request)
    {
        try {
            return response(SearchToSelectObjectService::search($request), 200);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function paginateCreate(Request $request)
    {
        try {
            return PaginateObjectService::paginateCreate($request);
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function print($objectId)
    {
        try {
            $object = ObjectModel::query()->findOrFail($objectId);
            $data = [
                'code' => $object->number,
                'description' => $object->description,
                'customer'  => $object->customer->name,
                'qrcode' => QrCode::format('png')->size(40)->generate($object->number),
                'quantity'  => $object->quantity,
            ];
            $pdf = App::make('dompdf.wrapper');
            $pdf->setPaper(array(0, 0, 400, 300), 'landscape');
            $pdf->setOption('javascript-delay', 3000);
            $pdf->setOption('isRemoteEnabled', true);
            $pdf->loadView('pdf', $data);
            return $pdf->download('teste.pdf');
        } catch (Exception $e) {
            Log::error($e);
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }

    public function store(ObejctoToOrderRequest $request)
    {
        try {
            return response(StoreObectToOrderService::store($request->all()), 200);
        } catch (Exception $e) {
            Log::error($e);
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
