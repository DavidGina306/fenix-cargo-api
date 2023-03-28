<?php

namespace App\Services\Country;

use App\Models\Country;
use Exception;
use Illuminate\Support\Facades\Log;

class SearchToSelecCountryService
{
    public static function search($request)
    {
        try {
            $response =  Country::query();
            if ($search = $request->search) {
                $response->where('nome', 'like', "%$search%")->orWhere('id', 'like', "%$search%");
            }
            return $response->whereStatus('E')->select(['id as code', 'nome as label'])->get();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Country', 500);
        }
    }
}
