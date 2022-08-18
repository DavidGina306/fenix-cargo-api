<?php

namespace App\Services\Address;

use App\Models\Address;
use Exception;
use Illuminate\Support\Facades\Log;

class StoreAddressService
{
    public static function store($request)
    {
        try {
            $address = Address::create(
                [
                    'address_line_1' => $request['address_line_1'], 'address_line_2' => $request['address_line_2'], 'address_line_3' => $request['address_line_3'] ?? "",
                    'town' => $request['town'],    'country' => $request['country'], 'postcode' => $request['postcode']
                ]
            );
            return $address;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Address', 500);
        }
    }
}
