<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'unique_identification_number' => $this->unique_identification_number,
            'business_identification_number' => $this->business_identification_number,
            'status' => $this->status,
            'customer_type' => $this->customer_type,
            'relationship_manager_name' => $this->relationship_manager_name,
            'business_segment' => $this->business_segment,
            'organization_type' => $this->organization_type,
            'bank' => $this->bank->name,
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }

}
