<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClosedDealsReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $closedActivities = $this->ClosedActivity->filter(function ($activity) {
            return in_array($activity->section, ['Contact', 'Lead', 'Opportunity', 'Emailing Documents']);
        })->map(function ($activity) {
            return [
                'id' => $activity->id,
                'section' => $activity->section,
                'tatDays' => $this->getTatDays($this->created_at),
                'updated_at' => $activity->updated_at->toDateTimeString(),
                'createdAt' => $activity->created_at->toDateTimeString(),
            ];
        });
        return [
            'id' => $this->id,
            'name' => $this->name,
            'company' => $this->company,
            'product' => $this->product,
            'stage' => $this->stage,
            'activities' => $closedActivities,
            'createdAt' => $this->created_at->toDateTimeString(),
            'pipeline_updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }

    public function getTatDays($date)
    {
        $now = Carbon::now();
        return $now->diffInDays($date);

    }
}
