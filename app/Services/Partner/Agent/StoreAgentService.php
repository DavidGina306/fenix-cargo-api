<?php

namespace App\Services\Partner\Agent;

use App\Models\Partner;
use App\Models\PartnerAgent;
use App\Models\Profile;
use App\Services\User\StoreUserService;
use App\User;
use Exception;
use Illuminate\Support\Facades\Log;

class StoreAgentService
{
    public static function store(array $request, Partner $partner)
    {
        try {
            $agents = [];
            if (isset($request['agents'])) {
                Log::info($request['agents']);
                foreach ($request['agents'] as $value) {
                    $user = User::query()->whereEmail($value['email'])->first();
                    if (!$user) {
                        $user = self::storeUser($value);
                    }
                    array_push($agents, PartnerAgent::query()->create([
                        'name' => $value['name'],
                        'role' => $value['role'] ?? "",
                        'email' => $value['email'],
                        'contact' => $value['contact'],
                        'departament' => $value['departament'] ?? "",
                        'partner_id' => $partner->id,
                        "user_id" => $user->id
                    ]));
                }
            } else {
                $user = User::query()->whereEmail($request['email'])->first();
                if (!$user) {
                    $user = self::storeUser($request);
                }
                $agents[] = PartnerAgent::query()->create([
                    'name' => $request['name'],
                    'role' => $request['role'] ?? "",
                    'email' => $request['email'],
                    'contact' => $request['contact'],
                    'partner_id' => $partner->id,
                    "user_id" => $user->id
                ]);
            }
            return $agents;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register Agent Partner', 500);
        }
    }

    public static function storeUser($data)
    {
        try {
            $dataUser = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => "Abcd@1234",
                'profile_id' => Profile::query()->whereName('agent_partner')->first()->id
            ];
            Log::alert($dataUser);
            return StoreUserService::store($dataUser);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register User to Agent Partner', 500);
        }
    }
}
