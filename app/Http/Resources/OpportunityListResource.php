<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OpportunityListResource extends JsonResource
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
            'source' => $this->source,
            'email' => $this->email,
            'contact_name' => $this->contact_name,
            'phone_number' => $this->phone_number,
            'region' => $this->region,
            'status' => $this->status,
            'converted_on' => $this->created_at->format('d-M-Y'),
        ];
    }
}
