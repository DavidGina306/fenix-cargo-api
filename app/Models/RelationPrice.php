<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Jamesh\Uuid\HasUuid;

class RelationPrice extends Model
{
    use HasUuid;
    protected $guarded = [];

    /**
     * Get the partner that owns the RelationPrice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }


    /**
     * Get the feeType that owns the RelationPrice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feeType(): BelongsTo
    {
        return $this->belongsTo(FeeType::class);
    }

    /**
     * Get all of the relationPrices for the RelationPrice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function relationPriceDetails(): HasMany
    {
        return $this->hasMany(RelationPriceDetail::class);
    }
}
