<?php

namespace App\Services\Partner\Bank;

use App\Models\Bank;
use App\Models\Partner;
use App\Models\PartnerDetailBank;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class StoreBankDataService
{
    public static function store(array $request, Partner $partner)
    {
        try {
            $bank = Bank::query()->findOrFail($request['bank_id']);
            $partberDetailBank = PartnerDetailBank::query()->create([
                'agency' => $request['agency'],
                'checking_account' => $request['checking_account'],
                'beneficiaries' => $request['beneficiaries'],
                'pix' => $request['pix'],
                'partner_id' => $partner->id,
                'bank_id' => $bank->id,
            ]);
            return $partberDetailBank;
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
