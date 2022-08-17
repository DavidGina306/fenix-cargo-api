<?php

namespace App\Services\Partner;

use App\Http\Resources\PartnerResource;
use App\Models\Partner;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class GetPartnerService
{
    public static function get($partnerId)
    {
        try {
            $partner = Partner::query()->findOrFail($partnerId);
            return new PartnerResource($partner);
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Partner':
                    throw new Exception('Partner not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Partner', 500);
        }
    }
}
