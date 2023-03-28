<?php

namespace App\Services\Country;

use App\Models\Country;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdateCountryService
{
    public static function update($request, $countryId)
    {
        try {
            $country = Country::query()->findOrFail($countryId);
            $country->update(
                [
                    'nome' => $request['nome'],
                    'ordem' => $request['ordem'],
                    'sigla2'=> $request['sigla2'],
                    'sigla3'=> $request['sigla3'],
                    'codigo' => $request['codigo']
                ]
            );
            return $country->fresh();
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Country':
                    throw new Exception('Country not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to update Country', 500);
        }
    }
}
