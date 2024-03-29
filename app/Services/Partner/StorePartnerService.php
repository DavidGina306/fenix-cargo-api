<?php

namespace App\Services\Partner;

use App\Helpers\GenderHelper;
use App\Services\Address\StoreAddressService;
use App\Services\Partner\Agent\StoreAgentService;
use App\Models\Partner;
use App\Services\Partner\Bank\StoreBankDataService;
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
                    'profile' => $request['profile'],
                    'gender' => isset($request['gender']) ? GenderHelper::getGenderValue($request['gender']) : null,
                    'document' => $request['document'],
                    'document_2' => $request['document_2'] ?? "",
                    'address_id' => $address->id
                ]
            );
            StoreAgentService::store($request, $partner);
            StoreBankDataService::store($request['bank_data'], $partner);
            return $partner->fresh();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Partner', 500);
        }
    }
}
