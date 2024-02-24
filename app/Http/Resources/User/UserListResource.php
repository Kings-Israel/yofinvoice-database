<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'fullName'=>$this->name,
            'role'=>$this->role,
            'username'=>$this->name,
            'email'=>$this->email,
            'status'=>$this->status,
            'contact'=>$this->contact,
            'avatar'=>asset('images/avatars/yofinvoice.png')
        ];
    }
}
