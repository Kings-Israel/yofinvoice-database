<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PipelineContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'department' => $this->department,
            'name' => $this->name,
            'phoneNumber' => $this->phone_number,
            'region' => $this->region,
            'gender' => ucfirst($this->gender),
            'status' => $this->status,
            'source' => $this->source,
        ];
    }
}
