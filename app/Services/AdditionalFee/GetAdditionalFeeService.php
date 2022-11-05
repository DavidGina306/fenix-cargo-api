<?php

namespace App\Services\AdditionalFee;

use App\Http\Resources\AdditionalFeeResource;
use App\Models\AdditionalFee;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class GetAdditionalFeeService
{
    public static function get($additionalFeeId)
    {
        try {
            $additionalFee = AdditionalFee::query()->findOrFail($additionalFeeId);
            return new AdditionalFeeResource($additionalFee);
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\AdditionalFee':
                    throw new Exception('AdditionalFee not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get AdditionalFee', 500);
        }
    }
}
