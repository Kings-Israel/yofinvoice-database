<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
        $NPADate = Carbon::parse($this->due_date);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'npa_status' => $this->npa_status,
            'npa_date' => $NPADate->format('d M Y'),
            'asset_classification_code' => $this->asset_classification_code,
            'approval_status' => $this->approval_status,
            'status' => $this->status,
            'bank' => $this->bank,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }

}
