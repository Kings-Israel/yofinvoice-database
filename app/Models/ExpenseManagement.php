<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseManagement extends Model
{
    use HasFactory, Searchable;
    protected $guarded = [''];

    protected $searchable = [
        'lead_name',
        'activity',
        'amount',
        'request_date',
        'notes',
    ];
}
