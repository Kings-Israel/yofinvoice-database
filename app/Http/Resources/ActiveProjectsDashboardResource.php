<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActiveProjectsDashboardResource extends JsonResource
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
            'progress' => $this->stageCount($this->stage),
        ];
    }
    public function stageCount($stage)
    {
        $stageCounts = [
            'Contact' => 2,
            'Lead' => 3,
            'Opportunity' => 4,
            'Closed' => 5,
        ];
        return $stageCounts[$stage] ?? 0;

    }
}
