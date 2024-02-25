<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory, Searchable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'start',
        'end',
        'allDay',
        'url',
        'extendedProps',
    ];
    protected $searchable = [
        'title',
        'start',
        'end',
        'allDay',
        'url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'allDay' => 'boolean',
        'extendedProps' => 'array',
        'start' => 'date:D-m-Y',
        'end' => 'date:D-m-Y',
    ];
}
