<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactUIPipelineResource extends JsonResource
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
            'stage' => $this->stage,
            'company' => $this->company,
            'department' => $this->department,
            'email' => $this->email,
            'source' => $this->source,
            'status' => $this->status,
            'product' => $this->product,
            'contacts' => PipelineContactResource::collection($this->whenLoaded('Contacts')),
        ];
    }
}
