<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoleType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    // protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * Get all of the Groups for the RoleType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Groups(): HasMany
    {
        return $this->hasMany(TargetRole::class);

    }
}
