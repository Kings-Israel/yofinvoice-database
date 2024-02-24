<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllProgramResource extends JsonResource
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
            'bank' => $this->bank,
            'company' => $this->company,
            'total_program_limit' => $this->total_program_limit,
            'utilized_limit' => $this->utilized_limit,
            'pipeline_requests' => $this->pipeline_requests,
            'margin_rate' => $this->margin_rate,
            'base_rate_consideration' => $this->base_rate_consideration,
            'anchor_discount_bearing' => $this->anchor_discount_bearing,
            'eligibility' => $this->eligibility,
        ];

    }
}
