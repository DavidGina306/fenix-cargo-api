<?php

namespace App\Services\User;

use App\Http\Resources\UserResource;
use App\Models\Customer;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class GetUserService
{
    public static function get($userId)
    {
        try {
            $user = User::query()->findOrFail($userId);
            return new UserResource($user);
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
            throw new Exception('Error to get User', 500);
        }
    }
}
