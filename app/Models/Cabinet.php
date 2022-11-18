<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    /**
     * Get the customer that owns the Cabinet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the customer that owns the Cabinet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
}
