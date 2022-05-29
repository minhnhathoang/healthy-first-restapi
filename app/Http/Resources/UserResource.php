<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'full_name' => $this->full_name,
            'email' => $this->email,
            'role' => $this->role_id == Role::ADMIN ? 'Admin' : 'User',
            'address' => $this->address,
            'mobile' => $this->mobile,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'joined_on' => Carbon::parse($this->created_at)->toDateString()
        ];
    }
}
