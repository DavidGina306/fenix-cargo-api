<?php

namespace App\Services\User;

use App\User;
use Exception;
use Illuminate\Support\Facades\Log;

class StoreUserService
{
    public static function store($request)
    {
        try {
            $user = User::create(
                [
                    'name' => $request['name'],
                    'email' => $request['email'],
                    'password' => $request['password']
                ]
            );
            return $user;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            throw new Exception('Error to register User', 500);
        }
    }
}
