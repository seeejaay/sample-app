<?php

namespace App\Http\Resources\UserResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserMinimalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->getFullNameAttribute(),
            'email' => $this->email,
            'role' =>  $this->role->name,
            'position' =>  $this->position->name,
        ];
    }
}