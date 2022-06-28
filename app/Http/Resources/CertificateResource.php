<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $date1 = Carbon::createFromFormat('Y-m-d', $this->due_date);
        $date2 = Carbon::createFromFormat('Y-m-d', Carbon::today()->toDateString());
        return [
            'establishment_id' => $this->establistment_id,
            'registration_number' => $this->registration_number,
            'date_issued' => $this->date_issued,
            'due_date' => $this->due_date,
            'is_revoked' => $this->is_revoked,
            'is_expired' => $date1->lt($date2),
            'time_remaining' => Carbon::createFromFormat('Y-m-d', $this->due_date)->diffForHumans()
        ];
    }
}
