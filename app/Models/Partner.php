<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Jamesh\Uuid\HasUuid;

class Partner extends Model
{
    use HasUuid;
    protected $guarded = [];


    /**
     * Get all of the comments for the PartnerAgent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agents(): HasMany
    {
        return $this->hasMany(PartnerAg::class);
    }

    /**
     * Get the user that owns the Partner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
}
