<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecentDashboardProspect extends JsonResource
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
            'stage' => $this->stage,
            'phoneNumber' => $this->phone_number,
            'createdAt' => $this->created_at->format('d-M-Y'),
            'status' => $this->status,
        ];
    }
}
