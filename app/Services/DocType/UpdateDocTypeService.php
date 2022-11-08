<?php

namespace App\Services\DocType;

use App\Models\DocType;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdateDocTypeService
{
    public static function update($request, $docTypeId)
    {
        try {
            $user = DocType::query()->findOrFail($docTypeId);
            $user->update(
                [
                    'name' => $request['name']
                ]
            );
            return $user->fresh();
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
            throw new Exception('Error to update DocType', 500);
        }
    }
}
