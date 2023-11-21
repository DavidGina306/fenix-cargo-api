<?php

namespace App\Services\Cabinet\Object;

use App\Models\Customer;
use App\Models\Locale;
use App\Models\ObjectModel;
use App\Models\Order;
use App\Models\Status;
use App\Services\Address\StoreAddressService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class StoreObjectToOrderService
{
    public static function store(array $request): Order
    {
        try {
            // Validar a existência do cliente
            $customer = Customer::findOrFail($request['customer_id']);

            // Criar um endereço para o destinatário
            $addressRecipient = StoreAddressService::store($request['address']);

            // Validar a existência do local
            $locale = Locale::findOrFail($request['locale_id']);

            $items = [];
            $totalQuantity = 0;
            $height = 0;
            $width = 0;
            $length = 0;
            $weight = 0;
            $objectsToSync = [];

            foreach ($request['items'] as $value) {
                // Buscar o objeto com base no número
                $object = ObjectModel::where('number', $value['number'])->first();

                if ($object) {
                    // Adicionar o objeto à lista de itens encontrados
                    $items[] = $object;

                    // Atualizar as métricas e a quantidade total
                    $totalQuantity += $value['quantity'];
                    $height += $object->height;
                    $width += $object->width;
                    $length += $object->length;
                    $weight += $object->weight;

                    // Preparar os dados para sincronização
                    $objectsToSync[$object->id] = ['current_quantity' => $object->current_quantity];
                }
            }

            // Criar o pedido
            $order = Order::create([
                'payer_id' => $customer->id,
                'number' => substr(str_shuffle(time() . mt_rand(0, 999) . md5(time() . mt_rand(0, 999))), 0, 16),
                'sender_id' => $customer->id,
                'sender_name' => $customer->name,
                'sender_address_id' => $customer->address->id,
                'sender_search_for' => "",
                'recipient_id' => $customer->id,
                'recipient_name' => $customer->name,
                'recipient_address_id' => $addressRecipient->id,
                'locale_id' => $locale->id,
                'status_id' => Status::where('name', 'Aguardando Coleta')->first()->id,
                'quantity' => $totalQuantity,
                'height' => $height,
                'width' => $width,
                'length' => $length,
                'weight' => $weight,
                'value' => 0.0,
                'total_weight' => 0.0,
                'open_date' => isset($request['open_date']) ? new Carbon($request['open_date']) : Carbon::now(),
                'notes' => 'Observação',
            ]);

            // Sincronizar os objetos com o pedido
            $order->objects()->sync($objectsToSync);

            return $order;
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Customer':
                    throw new Exception('Customer not found', 404);
                    break;
                case 'App\Models\Locale':
                    throw new Exception('Locale not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found in Object', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register ObjectToOrder', 500);
        }
    }
}
