<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class PackingType extends Model
{
    use HasUuid;
    protected $guarded = [];
}
