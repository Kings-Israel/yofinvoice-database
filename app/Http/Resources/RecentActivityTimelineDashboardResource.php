<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecentActivityTimelineDashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start' => $this->start,
            'end' => $this->end,
            'allDay' => $this->allDay,
            'createdAt' => $this->created_at,
            'url' => $this->url,
            'extendedProps' => [
                'guests' => $this->extendedProps['guests'] ?? [],
                'location' => $this->extendedProps['location'] ?? '',
                'description' => $this->extendedProps['description'] ?? '',
                'calendar' => $this->extendedProps['calendar'] ?? '',
            ],
        ];
    }
}
