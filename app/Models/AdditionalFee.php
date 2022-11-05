<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Jamesh\Uuid\HasUuid;

class AdditionalFee extends Model
{
    use HasUuid;
    protected $guarded = [];

    /**
     * The roles that belong to the Variation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function quotes(): BelongsToMany
    {
        return $this->belongsToMany(Quote::class, 'additional_fee_quote', 'additional_fee_id', 'quote_id');
    }
}
