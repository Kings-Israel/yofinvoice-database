<?php

namespace App\Helpers;

use App\Models\Activity;

class ActivityHelper
{
    public static function logActivity(array $data)
    {
        Activity::create([
            'subject_type' => $data['subject_type'] ?? 'None',
            'stage' => $data['stage'] ?? null,
            'section' => $data['section'] ?? null,
            'pipeline_id' => $data['pipeline_id'] ?? null,
            'user_id' => $data['user_id'],
            'description' => $data['description'],
            'properties' => $data['properties'] ?? [],
        ]);
    }
}
