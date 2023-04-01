<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
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
        return $this->hasMany(PartnerAgent::class);
    }

      /**
     * Get all of the bankData for the PartnerAgent
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bankData(): HasOne
    {
        return $this->hasOne(PartnerDetailBank::class);
    }

    /**
     * Get the user that address the Partner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }
}
