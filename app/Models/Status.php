<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class Status extends Model
{
    use HasUuid;
    protected $guarded = [];
    public $timestamps = false;
}
