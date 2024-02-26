<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyUIResource extends JsonResource
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
            'username' => $this->name,
            'company' => $this->company,
            'email' => $this->email,
            'county' => $this->region ?? "Nairobi",
            'contact' => $this->phone_number,
            'status' => $this->status,
            'industry' => $this->product,
            'avatar' => asset('images/avatars/yofinvoice.png'),
        ];
    }
}
