<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ObjectModel;
use App\Services\Cabinet\Object\PaginateObjectService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

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
                'customer'  => $object->customer->name
            ];
            $pdf = App::make('dompdf.wrapper');
            $pdf->setPaper(array(0, 0, 400, 400), 'landscape');
            $pdf->setOption('javascript-delay', 3000);
            $pdf->loadView('pdf', $data);
            return $pdf->download('teste.pdf');
        } catch (Exception $e) {
            return response(['error' => $e, 'message' => $e->getMessage(),], 400);
        }
    }
}
