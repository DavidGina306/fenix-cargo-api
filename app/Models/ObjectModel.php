<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Jamesh\Uuid\HasUuid;

class ObjectModel extends Model
{
    use HasUuid;
    protected $guarded = [];
    protected $table = 'objects';

    /**
     * Undocumented function
     *
     * @return BelongsTo
     */
    public function cabinet(): BelongsTo
    {
        return $this->belongsTo(Cabinet::class);
    }

     /**
     * Undocumented function
     *
     * @return BelongsTo
     */
    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class);
    }

    /**
 * Undocumented function
 *
 * @return BelongsTo
 */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

     /**
     * Get all of the post's comments.
     */
    public function medias()
    {
        return $this->morphMany(Media::class, 'mediable');
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
