<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class PriceType extends Model
{
    use HasUuid;
    protected $guarded = [];
}
