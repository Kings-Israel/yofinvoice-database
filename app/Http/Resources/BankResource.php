<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankResource extends JsonResource
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
            'url' => $this->url,
            'email' => $this->email,
            'contact_person' => $this->Admin->name ?? 'Not Admin',
            'created_at' => $this->created_at->format('d/M/Y'),
        ];
    }
}
