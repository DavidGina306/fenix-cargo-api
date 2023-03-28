<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Jamesh\Uuid\HasUuid;

class Order extends Model
{
    use HasUuid;
    protected $guarded = [];

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

    /**
     * Get the customer that owns the Cabinet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function locale(): BelongsTo
    {
        return $this->belongsTo(Locale::class);
    }

    /**
     * The objects that belong to the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function objects(): BelongsToMany
    {
        return $this->belongsToMany(ObjectModel::class, 'order_object', 'order_id', 'object_id');
    }

    /**
     * Get all of the orderMovements for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderMovements(): HasMany
    {
        return $this->hasMany(OrderMovement::class);
    }

    /**
     * Get all of the orderMovements for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function warnings(): HasMany
    {
        return $this->hasMany(OrderWarning::class);
    }

    /**
     * The status that belong to the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
