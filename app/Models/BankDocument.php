<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankDocument extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'requires_expiry_date'];

    /**
     * Get the bank that owns the BankDocument
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
}
