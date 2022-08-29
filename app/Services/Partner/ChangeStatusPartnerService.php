<?php

namespace App\Services\Partner;

use App\Http\Resources\partnerResource;
use App\Models\Partner;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class ChangeStatusPartnerService
{
    public static function changeStatus($partnerId)
    {
        try {
            $partner = Partner::query()->findOrFail($partnerId);
            $partner->update([
                'status' => $status = $partner->status == 'D' ? 'E' : 'D'
            ]);
            self::changeStatusAgents($partner, $status);
            return new PartnerResource($partner->fresh());
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
            throw new Exception('Error to update Status Partner', 500);
        }
    }


    public static function changeStatusAgents(Partner $partner, $status)
    {
        try {
            foreach ($partner->agents as $agent) {
                $agent->user->update([
                    'status' => $status
                ]);
                $agent->update([
                    'status' => $status
                ]);
            }
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to update Status Parter Agent ', 500);
        }
    }
}
