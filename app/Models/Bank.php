<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The users that belong to the Bank
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bank_users', 'user_id', 'bank_id');
    }

    /**
     * Get all of the companies for the Bank
     */
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }
}
