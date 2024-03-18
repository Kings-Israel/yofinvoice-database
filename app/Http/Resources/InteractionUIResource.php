<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InteractionUIResource extends JsonResource
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
            'stage' => "Stage: " . $this->stage,
            'touchPoint' => $this->touchPoint,
            'description' => $this->remarks,
            'date' => $this->created_at->format('d M Y'),
        ];
    }
}
