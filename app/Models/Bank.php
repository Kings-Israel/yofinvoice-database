<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bank extends Model
{
    use HasFactory, Searchable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [''];

    protected $searchable = [
        'name',
        'email',
    ];

    /**
     * The users that belong to the Bank
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bank_users');
    }

    /**
     * Get all of the companies for the Bank
     */
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    /**
     * Get all of the requiredDocuments for the Bank
     */
    public function requiredDocuments(): HasMany
    {
        return $this->hasMany(BankDocument::class);
    }

    /**
     * Get all of the paymentAccounts for the Bank
     */
    public function paymentAccounts(): HasMany
    {
        return $this->hasMany(BankPaymentAccount::class);
    }
    /**
     * Get the admin associated with the Bank
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Admin(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'contact_person_id', );
    }
}
