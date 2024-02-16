<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestDocument extends Model
{
    use HasFactory;

    /**
     * Get the company that owns the RequestDocument
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
