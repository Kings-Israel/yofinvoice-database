<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pipeline extends Model
{
    use HasFactory, Searchable;
    protected $guarded = [''];

    protected $searchable = [
        'name',
        'created_at',
        'email',
        'point_of_contact',
    ];

    /**
     * Get all of the Schedules for the Pipeline
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Schedules(): HasMany
    {
        return $this->hasMany(Schedule::class, 'pipeline_id', 'id');
    }
    /**
     * Get the CreationDate associated with the Pipeline
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function CreationDate(): HasOne
    {
        return $this->hasOne(Activity::class, 'pipeline_id', 'id');
    }
    /**
     * Get all of the ClosedActivity for the Pipeline
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ClosedActivity(): HasMany
    {
        return $this->hasMany(Activity::class, 'pipeline_id', 'id');
    }
    /**
     * Get all of the Contacts for the Pipeline
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Contacts(): HasMany
    {
        return $this->hasMany(Pipeline::class, 'pipeline_id', 'id');
    }
}
