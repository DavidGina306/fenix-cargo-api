<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StoreMediasService
{
    public static function store(array $data)
    {
        $image_64 = $data['value'];
        $fileName = sha1($data['value']) . '.' . mb_strtolower($data['type']);
        if (!Storage::disk('public')->exists($fileName)) {
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
            $image = str_replace(' ', '+', str_replace($replace, '', $image_64));
            Storage::disk('public')->put($fileName, base64_decode($image));
        }

        return $fileName;
    }
}
