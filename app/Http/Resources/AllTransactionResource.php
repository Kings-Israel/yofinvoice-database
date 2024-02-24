<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $formattedAmount = 'Ksh ' . number_format($this->payment_amount, 2);

        $paymentDate = Carbon::parse($this->payment_date);
        $dueDate = Carbon::parse($this->due_date);
        // $requestedDate = Carbon::parse($this->date_requested);

        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,
            'vendor' => $this->vendor,
            'anchor' => $this->anchor,
            'bank' => $this->bank,
            'payment_date' => $paymentDate->format('d/m/Y'),
            'due_date' => $dueDate->format('d/m/Y'),
            'payment_amount' => $formattedAmount,
            'eligibility_percentage' => $this->eligibility_percentage,
            'status' => $this->status,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];

    }
}
