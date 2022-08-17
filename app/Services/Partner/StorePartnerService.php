<?php

namespace App\Services\Partner;

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
            Log::alert($request);
            $address = StoreAddressService::store($request['address']);
            $partner = Partner::create(
                ['name' => $request['name'], 'number_doc' => $request['number_doc'], 'address_id' => $address->id]
            );
            StoreAgentService::store($request, $partner);
            return $partner->fresh();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Partner', 500);
        }
    }
}
