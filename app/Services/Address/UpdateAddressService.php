<?php

namespace App\Services\Address;

use App\Models\Profile;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdateAddressService
{
    public static function update($request, $addresId)
    {
        try {
            $address = Profile::query()->findOrFail($addresId);
            $address->update(
                [
                    'postcode' => $request['postcode'],
                    'address_line_1' => $request['address_line_1'],
                    'address_line_2' => $request['address_line_2'],
                    'address_line_3' => $request['address_line_3'],
                    'town' => $request['town'],
                    'state' => $request['state'],
                    'country' => $request['country'],
                ]
            );
            return $address->fresh();
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Address':
                    throw new Exception('Address not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to update User', 500);
        }
    }
}
