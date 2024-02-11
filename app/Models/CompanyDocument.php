<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyDocument extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['company_id', 'name', 'expiry_date', 'status'];

    /**
     * Get the company that owns the CompanyDocument
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
