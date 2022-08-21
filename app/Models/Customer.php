<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jamesh\Uuid\HasUuid;

class Customer extends Model
{
    use HasUuid;
    protected $guarded = [];
    /**
     * Get all of the agens for the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agents(): HasMany
    {
        return $this->hasMany(CustomerAgent::class);
    }
}
