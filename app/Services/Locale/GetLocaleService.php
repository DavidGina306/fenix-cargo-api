<?php

namespace App\Services\Locale;

use App\Http\Resources\LocaleResource;
use App\Models\Locale;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class GetLocaleService
{
    public static function get($localeId)
    {
        try {
            $locale = Locale::query()->findOrFail($localeId);
            return new LocaleResource($locale);
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Locale':
                    throw new Exception('Locale not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Locale', 500);
        }
    }
}
