<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowUpUIResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $date = $this->date ?? now();
        $date = Carbon::parse($date);
        return [
            'id' => $this->id,
            'stage' => "Next Step: " . $this->veryNextStep,
            'touchPoint' => $this->veryNextStep,
            'checked' => $this->status == 1 ? 'Done' : ' Not Done',
            'description' => $this->remarks,
            'date' => $date->format('d M Y'),
        ];
    }
}
