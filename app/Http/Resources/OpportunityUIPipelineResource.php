<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OpportunityUIPipelineResource extends JsonResource
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
            'name' => $this->name,
            'converted_on' => $this->created_at->format('d-M-Y'),
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'branch' => $this->branch,
            'status' => $this->status,
        ];

    }
}
