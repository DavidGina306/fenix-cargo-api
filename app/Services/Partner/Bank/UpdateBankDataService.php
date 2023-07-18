<?php

namespace App\Services\Partner\Bank;

use App\Models\Bank;
use App\Models\Partner;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdateBankDataService
{
    public static function update(array $request, Partner $partner)
    {
        try {
            if ($partner->bankData) {
                $bank = Bank::query()->findOrFail($request['bank_id']);
                $partner->bankData->update([
                    'agency' => $request['agency'],
                    'checking_account' => $request['checking_account'],
                    'beneficiaries' => $request['beneficiaries'],
                    'pix' => $request['pix'],
                    'partner_id' => $partner->id,
                    'bank_id' => $bank->id,
                ]);
            } else {
                if ($request['bank_id']) {
                    $bank = Bank::query()->findOrFail($request['bank_id']);
                    $partner->bankData()->create([
                        'agency' => $request['agency'],
                        'checking_account' => $request['checking_account'],
                        'beneficiaries' => $request['beneficiaries'],
                        'pix' => $request['pix'],
                        'partner_id' => $partner->id,
                        'bank_id' => $bank->id
                    ]);
                }
            }
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Partner':
                    throw new Exception('Partner not found', 404);
                    break;
                case 'App\Models\Bank':
                    throw new Exception('Bank not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found in Partner', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Detail Bank', 500);
        }
    }
}
