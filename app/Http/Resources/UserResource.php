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
            'id' => $this->id,
            'full_name' => $this->full_name,
            'first_name' => $this->first_name,
            'surname' => $this->surname,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'role' => $this->role == 0 ? "Admin" : "Specialist",
            'address' => $this->address,
            'avatar' => $this->avatarLink,
            'mobile' => $this->mobile,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'joined_on' => Carbon::parse($this->created_at)->toDateString()
        ];
    }
}
