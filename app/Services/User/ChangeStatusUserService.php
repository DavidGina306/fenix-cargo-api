<?php

namespace App\Services\User;

use App\Http\Resources\UserResource;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class ChangeStatusUserService
{
    public static function changeStatus($userId)
    {
        try {
            $user = User::query()->findOrFail($userId);
            $user->update([
                'status' => $user->status == 'D' ? 'E' : 'D'
            ]);
             return new UserResource($user->fresh());
        } catch (ModelNotFoundException $e) {
            switch ($e->getModel()) {
                case 'App\User':
                    throw new Exception('User not found', 404);
                    break;
                default:
                    throw new Exception('Error Model not found', 404);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to update Status User', 500);
        }
    }
}
