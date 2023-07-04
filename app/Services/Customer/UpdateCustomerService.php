<?php

namespace App\Services\Customer;

use App\Helpers\GenderHelper;
use App\Models\Customer;
use App\Models\CustomerAgent;
use App\Models\Profile;
use App\Services\Address\UpdateAddressService;
use App\Services\User\StoreUserService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdateCustomerService
{
    public static function update($request, $customerId)
    {
        try {
            $customer = Customer::query()->findOrFail($customerId);
            $customer->update(
                [
                    'name' => $request['name'],
                    'role' => $request['role'] ?? "",
                    'type' => $request['type'],
                    'gender' => isset($request['gender']) ? GenderHelper::getGenderValue($request['gender']) : null,
                    'document' => $request['document'],
                    'document_2' => $request['document_2'] ?? "",
                ]
            );
            UpdateAddressService::update($request['address'], $customer->address->id);
            self::updateAgents($request['agents'], $customer);
            return $customer->fresh();
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Customer':
                    throw new Exception('Customer not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to update Customer', 500);
        }
    }

    public static function updateAgents($agents, Customer $customer)
    {
        try {
            $ids = [];
            foreach ($agents as $agent) {
                if (isset($agent['id'])) {
                    $dataAgent = CustomerAgent::query()->findOrFail($agent['id']);
                    $dataAgent->update([
                        'email' => $agent['email'],
                        'name' => $agent['name'],
                        'departament' => $agent['departament'],
                        'contact' => $agent['contact']
                    ]);
                } else {

                    $dataUser = [
                        'name' => $agent['name'],
                        'email' => $agent['email'],
                        'password' => "Abcd@1234",
                        'profile_id' => Profile::query()->whereName('agent_customer')->first()->id
                    ];
                    $user = StoreUserService::store($dataUser);
                    $dataAgent = $customer->agents()->create(
                        [
                            'email' => $agent['email'],
                            'name' => $agent['name'],
                            'contact' => $agent['contact'],
                            'departament' => $agent['departament'],
                            'user_id' => $user->id
                        ]
                    );
                }
                array_push($ids, $dataAgent->id);
            }
            Log::warning([$ids, count($ids)]);
            if(count($ids)) {
                self::deleteAgents($ids, $customer);
            }
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\CustomerAgent':
                    throw new Exception('CustomerAgent not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to update CustomerAgent', 500);
        }
    }

    public static function deleteAgents(array $agentsId, Customer $customer)
    {
        try {
            $agents = $customer->agents->whereNotIn('id', $agentsId);
            foreach ($agents as $agent) {
                $agent->user()->delete();
                $agent->delete();
            }
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            throw new Exception('Error to delete CustomerAgent', 500);
        }
    }
}
