<?php

namespace App\Services\Country;

use App\Models\Country;
use Exception;
use Illuminate\Support\Facades\Log;

class StoreCountryService
{
    public static function store($request)
    {
        try {
            $country = Country::query()->firstOrCreate(
                [
                    'nome' => $request['nome'],
                    'ordem' => $request['ordem'],
                    'sigla2'=> $request['sigla2'],
                    'sigla3'=> $request['sigla3'],
                    'codigo' => $request['codigo']
                ]
            );
            return $country->fresh();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Country', 500);
        }
    }
}
