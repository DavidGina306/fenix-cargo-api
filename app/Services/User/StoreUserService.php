<?php

namespace App\Services\User;

use App\Models\Profile;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class StoreUserService
{
    public static function store($request)
    {
        try {
            $profile = Profile::query()->findOrFail($request['profile_id']);
            $user = User::create(
                [
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => $request['password'],
                    'profile_id' =>  $profile->id
                ]
            );
            return $user;
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\Models\Profile':
                    throw new Exception('Profile not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        }catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register User', 500);
        }
    }
}
