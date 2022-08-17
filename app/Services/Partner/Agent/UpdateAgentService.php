<?php

namespace App\Services\Partner\Agent;

use App\Models\Partner;
use App\Models\PartnerAgent;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdateAgentService
{
    public static function update(array $request, $partnerAgentId)
    {
        try {
            $agent = PartnerAgent::query()->findOrFail($partnerAgentId);

            $agent->update([
                'name' => $request['name'],
                'role' => $request['role'],
                'email' => $request['email'],
                'email_2' => $request['email_2'],
                'contact' => $request['contact'],
                'contact_2' => $request['contact_2']
            ]);
            return $agent->fresh();
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\PartnerAgent':
                    throw new Exception('PartnerAgent not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Partner Agent', 500);
        }
    }
}
