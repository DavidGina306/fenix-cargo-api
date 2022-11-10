<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jamesh\Uuid\HasUuid;

class ObjectModel extends Model
{
    use HasUuid;
    protected $guarded = [];
    protected $table = 'objects';

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
