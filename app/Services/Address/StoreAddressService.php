<?php

namespace App\Services\Address;

use App\Models\Address;
use App\Models\Country;
use Exception;
use Illuminate\Support\Facades\Log;

class StoreAddressService
{
    public static function store($request): Address
    {
        try {
            $country = Country::query()->where("id",$request['country'])->orWhere('nome', 'like', "%{$request['country']}%")->first();
            if ($country) {
                $countryName = $country->nome;
            } else {
                $countryName = $request['country'];
            }
            $address = Address::create(
                [
                    'address_line_1' => $request['address_line_1'],
                    'address_line_2' => $request['address_line_2'],
                    'address_line_3' => $request['address_line_3'] ?? "",
                    'town' => $request['town'],
                    'country' => $countryName,
                    'state' => $request['state'],
                    'postcode' => $request['postcode']
                ]
            );
            return $address;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Address', 500);
        }
    }
}
