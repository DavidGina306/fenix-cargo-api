<?php

namespace App\Services\Invoice;

use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class GetInvoiceService
{
    public static function get($InvoiceId)
    {
        try {
            $Invoice = Invoice::query()->findOrFail($InvoiceId);
            return new InvoiceResource($Invoice);
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Invoice':
                    throw new Exception('Invoice not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to get Invoice', 500);
        }
    }
}
