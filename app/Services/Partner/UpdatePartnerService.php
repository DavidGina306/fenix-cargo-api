<?php

namespace App\Services\Partner;

use App\Models\Partner;
use App\Models\PartnerAgent;
use App\Models\Profile;
use App\Services\Address\UpdateAddressService;
use App\Services\User\StoreUserService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdatePartnerService
{
    public static function update($request, $partnerId)
    {
        try {
            $partner = Partner::query()->findOrFail($partnerId);
            $partner->update(
                [
                    'name' => $request['name'],
                    'type' => $request['type'],
                    'gender' => $request['gender'],
                    'document' => $request['document'],
                    'email' => $request['email'],
                    'email_2' => $request['email_2'] ?? "",
                    'contact' => $request['contact']
                ]
            );
            UpdateAddressService::update($request['address'], $partner->address->id);
            self::updateAgents($request['agents'], $partner);
            return $partner->fresh();
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Partner':
                    throw new Exception('Partner not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found in Update Partner', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to update Partner', 500);
        }
    }

    public static function updateAgents($agents, Partner $partner)
    {
        try {
            $ids = [];
            foreach ($agents as $agent) {
                if (isset($agent['id'])) {
                    $dataAgent = PartnerAgent::query()->findOrFail($agent['id']);
                    $dataAgent->update([
                        'email' => $agent['email'],
                        'name' => $agent['name'],
                        'contact' => $agent['contact']
                    ]);
                } else {

                    $dataUser = [
                        'name' => $agent['name'],
                        'email' => $agent['email'],
                        'password' => "Abcd@1234",
                        'profile_id' => Profile::query()->whereName('agent_partner')->first()->id
                    ];
                    $user = StoreUserService::store($dataUser);
                    $dataAgent = $partner->agents()->create(
                        [
                            'email' => $agent['email'],
                            'name' => $agent['name'],
                            'contact' => $agent['contact'],
                            'user_id' => $user->id
                        ]
                    );
                }
                array_push($ids, $dataAgent->id);
            }
            Log::warning([$ids, count($ids)]);
            if(count($ids)) {
                self::deleteAgents($ids, $partner);
            }
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\PartnerAgent':
                    throw new Exception('PartnerAgent not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found in Partner', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to update PartnerAgent', 500);
        }
    }

    public static function deleteAgents(array $agentsId, Partner $partner)
    {
        try {
            $agents = $partner->agents->whereNotIn('id', $agentsId);
            foreach ($agents as $agent) {
                $agent->user()->delete();
                $agent->delete();
            }
        } catch (\Exception $th) {
            Log::error($th->getMessage());
            throw new Exception('Error to delete PartnerAgent', 500);
        }
    }
}
