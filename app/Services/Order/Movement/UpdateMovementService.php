<?php

namespace App\Services\Order\Movement;

use App\Models\OrderMovement;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdateMovementService
{
    public static function update(array $request): OrderMovement
    {
        try {
            $orderMovement = OrderMovement::query()->findOrFail($request['id']);
            $orderMovement->update([
                'document_type' => $request['document_type'],
                'doc_received_for' => $request['doc_received_for'],
                'received_for' => $request['received_for'],
                'locale' => $request['locale'],
            ]);
            return  $orderMovement;
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\OrderMovement':
                    throw new Exception('OrderMovement not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to update Status Customer', 500);
        }
    }
}
