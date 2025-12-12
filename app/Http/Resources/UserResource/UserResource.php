<?php

namespace App\Http\Resources\UserResource;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RoleResource\RoleDropdownResource;
use App\Http\Resources\PositionResource\PositionDropdownResource;
use App\Http\Resources\ScheduleResource\ScheduleDropdownResource;
class UserResource extends JsonResource
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
            'name' => $this->getFullNameAttribute(),
            'email' => $this->email,
            'role' => new RoleDropdownResource($this->role),
            'position' => new PositionDropdownResource($this->position),
            'schedules' => ScheduleDropdownResource::collection($this->schedules),
        ];
    }
    
}