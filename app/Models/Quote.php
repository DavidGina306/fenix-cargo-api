<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Jamesh\Uuid\HasUuid;

class Quote extends Model
{
    use HasUuid;
    protected $guarded = [];

    /**
     * Get the customer that owns the Quote
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the customer that owns the Quote
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feeType(): BelongsTo
    {
        return $this->belongsTo(FeeType::class);
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
     * Get the senderAddress that owns the Quote
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function senderAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'sender_address_id');
    }

    /**
     * Get the recipienteAddress that owns the Quote
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipienteAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'recipient_address_id');
    }

    /**
     * The roles that belong to the Variation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function additionalFees(): BelongsToMany
    {
        return $this->belongsToMany(AdditionalFee::class, 'additional_fee_quote', 'quote_id', 'additional_fee_id');
    }
}
