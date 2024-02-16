<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramBankUserDetails extends Model
{
    use HasFactory;

    /**
     * Get the program that owns the ProgramCompanyRole
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
