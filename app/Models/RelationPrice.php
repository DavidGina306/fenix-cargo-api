<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
     * Get the feeRule that owns the RelationPrice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feeRule(): BelongsTo
    {
        return $this->belongsTo(FeeRule::class);
    }

    /**
     * Get the currency that owns the RelationPrice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }
}
