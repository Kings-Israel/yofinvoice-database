<?php

namespace App\Http\Resources\Schedule;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuestListUIResource extends JsonResource
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
            'avatar' => asset('images/avatars/avatar-' . rand(1, 10) . '.png'),
        ];
    }
}
