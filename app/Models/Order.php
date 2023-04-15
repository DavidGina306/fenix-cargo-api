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
    public function sender(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'sender_id');
    }

    /**
     * Get the order that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function packingType(): BelongsTo
    {
        return $this->belongsTo(PackingType::class);
    }

    /**
     * Get the customer that owns the Quote
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function docType(): BelongsTo
    {
        return $this->belongsTo(DocType::class);
    }

    /**
     * Get the customer that owns the Cabinet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'recipient_id');
    }

    /**
     * Get the customer that owns the Cabinet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function addressSender(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'sender_address_id');
    }

    /**
     * Get the customer that owns the Cabinet
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function addressRecipient(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'recipient_address_id');
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
