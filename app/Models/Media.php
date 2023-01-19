<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class Media extends Model
{
    use HasUuid;
    protected $guarded = [];
    public $timestamps = false;

     /**
     * Get the parent mediable model.
     */
    public function mediable()
    {
        return $this->morphTo();
    }
}
