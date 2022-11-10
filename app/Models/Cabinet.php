<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Jamesh\Uuid\HasUuid;

class Cabinet extends Model
{
    use HasUuid;
    protected $guarded = [];

    /**
     * Get all of the relationPrices for the RelationPrice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function objects(): HasMany
    {
        return $this->hasMany(ObjectModel::class);
    }
}
