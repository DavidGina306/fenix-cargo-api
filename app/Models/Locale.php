<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class Locale extends Model
{
    use HasUuid;
    protected $guarded = [];
    public $timestamps = false;
}
