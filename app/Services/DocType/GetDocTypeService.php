<?php

namespace App\Services\DocType;

use App\Http\Resources\DocTypeResource;
use App\Models\DocType;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class GetDocTypeService
{
    public static function get($docTypeId)
    {
        try {
            $packingType = DocType::query()->findOrFail($docTypeId);
            return new DocTypeResource($packingType);
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\DocType':
                    throw new Exception('DocType not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get DocType', 500);
        }
    }
}
