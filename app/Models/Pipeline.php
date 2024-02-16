<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pipeline extends Model
{
    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'crm';

    use HasFactory;
}
