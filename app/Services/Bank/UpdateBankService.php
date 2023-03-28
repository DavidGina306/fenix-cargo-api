<?php

namespace App\Services\Bank;

use App\Models\Bank;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdateBankService
{
    public static function update($request, $bankId)
    {
        try {
            $bank = Bank::query()->findOrFail($bankId);
            $bank->update(
                [
                    'name' => $request['name'],
                    'code' => $request['code']
                ]
            );
            return $bank->fresh();
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Bank':
                    throw new Exception('Bank not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to update Bank', 500);
        }
    }
}
