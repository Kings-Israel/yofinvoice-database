<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseManagementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $formattedAmount = 'Ksh ' . number_format($this->amount, 2);

        return [
            'id' => $this->id,
            'lead_name' => $this->lead_name,
            'activity' => $this->activity,
            'amount' => $formattedAmount,
            'status' => $this->status,
            'date' => $this->created_at->format('d M Y'),
        ];
    }

}
