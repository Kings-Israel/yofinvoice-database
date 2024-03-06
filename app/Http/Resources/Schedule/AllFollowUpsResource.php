<?php

namespace App\Http\Resources\Schedule;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllFollowUpsResource extends JsonResource
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
            'url' => $this->url,
            'expired' => Carbon::parse($this->end)->isPast() ? 'expired' : 'active',
            'extendedProps' => [
                'guests' => $this->extendedProps['guests'] ?? [],
                'location' => $this->extendedProps['location'] ?? '',
                'description' => $this->extendedProps['description'] ?? '',
                'calendar' => $this->extendedProps['calendar'] ?? '',
            ],
        ];
    }
}
