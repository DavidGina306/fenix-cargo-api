<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jamesh\Uuid\HasUuid;

class PartnerAgent extends Model
{
    use HasUuid;
    protected $guarded = [];

    /**
     * Get the user that owns the Partner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }
}
