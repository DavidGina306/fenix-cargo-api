<?php

namespace App\Services\Cabinet;

use App\Http\Resources\CabinetResource;
use App\Models\Cabinet;
use Exception;
use Illuminate\Support\Facades\Log;

class PagenateCabinetService
{
    public static function paginate($request)
    {
        try {
            $response = Cabinet::query();

            if ($search = $request->search) {
                $response->where('storage_locale', 'like', "%$search%")->orWhere('order', 'like', "%$search%");
            }
            return CabinetResource::collection($response->paginate(12));
        }  catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Cabinet', 500);
        }
    }
}
