<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadUIPipelineResource extends JsonResource
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
            'company' => $this->company,
            'stage' => $this->stage,
            'name' => $this->name,
            'created_at' => $this->created_at->format('d-M-Y'),
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'source' => $this->source,
            'status' => $this->status,
        ];

    }
}
