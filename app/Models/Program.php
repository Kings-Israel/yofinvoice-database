<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Program extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the programType that owns the Program
     */
    public function programType(): BelongsTo
    {
        return $this->belongsTo(ProgramType::class);
    }

    /**
     * Get the programCode that owns the Program
     */
    public function programCode(): BelongsTo
    {
        return $this->belongsTo(ProgramCode::class);
    }

    /**
     * Get the bank that owns the Program
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    /**
     * Get all of the companies for the Program
     */
    public function companies(): HasManyThrough
    {
        return $this->hasManyThrough(Company::class, ProgramCompanyRole::class, 'program_id', 'id');
    }

    /**
     * Get the discountDetails associated with the Program
     */
    public function discountDetails(): HasOne
    {
        return $this->hasOne(ProgramDiscount::class);
    }

    /**
     * Get all of the fees for the Program
     */
    public function fees(): HasMany
    {
        return $this->hasMany(ProgramFee::class);
    }

    /**
     * Get all of the anchorDetails for the Program
     */
    public function anchorDetails(): HasMany
    {
        return $this->hasMany(ProgramAnchorDetails::class);
    }

    /**
     * Get all of the bankUserDetails for the Program
     */
    public function bankUserDetails(): HasMany
    {
        return $this->hasMany(ProgramBankUserDetails::class);
    }

    /**
     * Get all of the bankDetails for the Program
     */
    public function bankDetails(): HasMany
    {
        return $this->hasMany(ProgramBankDetails::class);
    }
}
