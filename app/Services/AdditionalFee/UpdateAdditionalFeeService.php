<?php

namespace App\Services\AdditionalFee;

use App\Helpers\MoneyToDecimal;
use App\Models\AdditionalFee;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdateAdditionalFeeService
{
    public static function update($request, $additionalFeeeId)
    {
        try {
            $additionalFeee = AdditionalFee::query()->findOrFail($additionalFeeeId);
            $additionalFeee->update(
                [
                    'name' => $request['name'],
                    'value' => MoneyToDecimal::moneyToDecimal($request['value'])
                ]
            );
            return $additionalFeee->fresh();
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\AdditionalFee':
                    throw new Exception('AdditionalFee not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to update AdditionalFee', 500);
        }
    }
}
