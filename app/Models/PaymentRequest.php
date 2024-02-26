<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentRequest extends Model
{
    use HasFactory;

    /**
     * Get the invoice that owns the PaymentRequest
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get all of the paymentAccounts for the PaymentRequest
     */
    public function paymentAccounts(): HasMany
    {
        return $this->hasMany(PaymentRequestAccount::class);
    }

    /**
     * Get all of the cbsTransactions for the PaymentRequest
     */
    public function cbsTransactions(): HasMany
    {
        return $this->hasMany(CbsTransaction::class);
    }
}
