<?php

namespace App\Http\Resources;

use App\Http\Resources\Schedule\AllFollowUpsResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadsReportResource extends JsonResource
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
            'name' => $this->name,
            'leadType' => $this->lead_type,
            'email' => $this->email,
            'pointOfContact' => $this->point_of_contact,
            'schedules' => AllFollowUpsResource::collection($this->whenLoaded('Schedules')),
            'CreationDate' => $this->whenLoaded('CreationDate') ? $this->CreationDate->created_at->format('d-M-y') : now(),
            'tatDays' => $this->getTatDays($this->CreationDate->created_at),
        ];
    }

    public function getTatDays($date)
    {
        $now = Carbon::now();
        return $now->diffInDays($date);

    }
}
