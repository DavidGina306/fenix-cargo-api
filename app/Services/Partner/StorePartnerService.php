<?php

namespace App\Services\Partner;

use App\Helpers\GenderHelper;
use App\Services\Address\StoreAddressService;
use App\Services\Partner\Agent\StoreAgentService;
use App\Models\Partner;
use Exception;
use Illuminate\Support\Facades\Log;

class StorePartnerService
{
    public static function store($request)
    {
        try {
            $address = StoreAddressService::store($request['address']);
            $partner = Partner::create(
                [
                    'name' => $request['name'],
                    'type' => $request['type'],
                    'gender' => isset($request['gender']) ? GenderHelper::getGenderValue($request['gender']) : null,
                    'document' => $request['document'],
                    'email' => $request['email'],
                    'email_2' => $request['email_2'] ?? "",
                    'contact' => $request['contact'],
                    'address_id' => $address->id
                ]
            );
            StoreAgentService::store($request, $partner);
            return $partner->fresh();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Partner', 500);
        }
    }
}
