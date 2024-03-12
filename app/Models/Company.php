<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;

class Company extends Model
{
    use HasFactory, HasRoles, Searchable;

    protected $searchable = [
        'name',
        'unique_identification_number',
        'branch_code',
        'business_identification_number',
        'organization_type',
        'customer_type',
        'bank.name',
    ];

    /**
     * Get the bank that owns the Company
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    /**
     * The users that belong to the Company
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'company_users', 'user_id', 'company_id');
    }

    /**
     * The roles that belong to the Company
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(ProgramRole::class, 'program_company_roles', 'company_id', 'role_id');
    }

    /**
     * Get all of the documents for the Company
     */
    public function documents(): HasMany
    {
        return $this->hasMany(CompanyDocument::class);
    }

    /**
     * Get all of the requestedDocuments for the Company
     */
    public function requestedDocuments(): HasMany
    {
        return $this->hasMany(RequestDocument::class);
    }

    /**
     * Get the pipeline associated with the Company
     */
    public function pipeline(): HasOne
    {
        return $this->hasOne(Pipeline::class, 'id', 'pipeline_id');
    }
}
