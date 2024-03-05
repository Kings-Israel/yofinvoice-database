<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankPaymentAccount extends Model
{
    use HasFactory;

    /**
     * Get the bank that owns the BankPaymentAccount
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
}
