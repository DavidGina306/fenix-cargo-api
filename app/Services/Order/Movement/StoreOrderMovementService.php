<?php

namespace App\Services\Order\Movement;

use App\Models\Media;
use App\Models\Order;
use App\Models\OrderMovement;
use App\Models\Status;
use App\Services\StoreMediasService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class StoreOrderMovementService
{
    public static function store(array $request): OrderMovement
    {
        try {
            $order = Order::query()->findOrFail($request['order_id']);
            $status = Status::query()->findOrFail($request['status_id']);

            $orderMovement = OrderMovement::create(
                [
                    'status_id' => $status->id,
                    'order_id' => $order->id,
                    'time' => $request['time'],
                    'entry_date' => isset($request['entry_date']) ? new Carbon($request['entry_date']) : Carbon::now(),
                    'received_for' => $request['received_for'],
                    'doc_received_for' => $request['doc_received_for'],
                    'document_type' => $request['document_type'],
                    'locale' => self::setLocale($order, $request)
                ]
            );
            self::storeImages($request['files'], $orderMovement->id);
            return $orderMovement;
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

     /**
     * funtion to get city
     *
     * @param Order $order
     * @param array $request
     * @return string
     */
    public static function setLocale(Order $order, array $request): string
    {
        try {
            Log::info($order);
            if ($request['city'] == 'O') {
                return $order->addressSender->town;
            } else if ($request['city'] == 'D') {
                return $order->addressRecipient->town;
            }
            return $request['other_city'];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register set Locale', 500);
        }
    }

    public static function storeImages(array $data, string $orderWaningId)
    {
        try {
            foreach ($data as $value) {
                $image = StoreMediasService::store($value);
                Media::query()->firstOrCreate(
                    [
                        "mediable_id" => $orderWaningId,
                        "mediable_type" => OrderMovement::class,
                        "url" => $image
                    ]
                );
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register images to Order Warnings', 500);
        }
    }
}
