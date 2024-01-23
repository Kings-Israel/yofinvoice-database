<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Traits\HasRoles;

class Company extends Model
{
    use HasFactory, HasRoles;

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
}
