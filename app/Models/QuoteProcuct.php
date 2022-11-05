<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jamesh\Uuid\HasUuid;

class QuoteProcuct extends Model
{
    use HasUuid;
    protected $guarded = [];

    /**
     * Get all of the users for the Profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quote(): BelongsTo
    {
        return $this->belongsTo(Quote::class);
    }
}
