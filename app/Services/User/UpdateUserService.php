<?php

namespace App\Services\User;

use App\Models\Profile;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class UpdateUserService
{
    public static function update($request, $userId)
    {
        try {
            $user = User::query()->findOrFail($userId);
            $profile = Profile::query()->findOrFail($request['profile_id']);
            $user->update(
                [
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => $request['password'],
                    'profile_id' => $profile->id
                ]
            );
            return $user->fresh();
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\User':
                    throw new Exception('User not found', 404);
                    break;
                case 'App\Models\Profile':
                    throw new Exception('Profile not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to update User', 500);
        }
    }
}
