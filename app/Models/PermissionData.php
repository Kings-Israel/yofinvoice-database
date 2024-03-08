<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionData extends Model
{
    use HasFactory;
    protected $guarded = [''];

    public function roleIDs()
    {
        return $this->hasMany(RoleId::class);
    }
}
