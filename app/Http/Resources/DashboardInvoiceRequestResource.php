<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardInvoiceRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $formattedAmount = 'Ksh ' . number_format($this->amount, 2);

        $expiryDate = Carbon::parse($this->expiry_date);
        $dueDate = Carbon::parse($this->due_date);
        $requestedDate = Carbon::parse($this->date_requested);

        return [
            'id' => $this->id,
            'vendor' => $this->vendor,
            'bank' => $this->bank,
            'anchor' => $this->anchor,
            'date_requested' => $requestedDate->format('d M y'),
            'amount' => $formattedAmount,
            'expiry_date' => $expiryDate->format('d M y'),
            'due_date' => $dueDate->format('d M y'),
            'status' => $this->status,
            'discount_amount' => $this->discount_amount,
        ];
    }

}
