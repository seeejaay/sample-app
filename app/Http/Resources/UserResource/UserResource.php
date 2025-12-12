<?php

namespace App\Http\Resources\UserResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

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
            'name' => $this->firstname . ' ' . $this->middlename . ' ' . $this->lastname,
            'email' => $this->email,
            'role' => [
                'id' => $this->role->id,
                'name' => $this->role->name,
            ],
            'position' => [
                'id' => $this->position->id,
                'name' => $this->position->name,
            ],
            'schedules' => $this->schedules->map(function($schedule) {
                return [
                    'id' => $schedule->id,
                    'shift_name' => $schedule->shift_name,
                    'time_in' => Carbon::parse($schedule->time_in)->format('h:i A'),
                    'time_out' => Carbon::parse($schedule->time_out)->format('h:i A'),
                ];
            }),
        ];
    }
}