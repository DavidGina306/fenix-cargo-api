<?php

namespace App\Services\Locale;

use App\Models\Locale;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdateLocaleService
{
    public static function update($request, $localeId)
    {
        try {
            $user = Locale::query()->findOrFail($localeId);
            $user->update(
                [
                    'name' => $request['name']
                ]
            );
            return $user->fresh();
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
            throw new Exception('Error to update Locale', 500);
        }
    }
}
