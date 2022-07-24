<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class ObjectModel extends Model
{
    use HasUuid;
    protected $guarded = [];
    protected $table = 'objects';

}
