<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EstablishmentResource extends JsonResource
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
            'name' => $this->name,
            'owner' => $this->owner,
            'address' => $this->address,
            'kind_of_business' => $this->kind_of_business,
            'telephone' => $this->telephone,
            'fax' => $this->fax,
            'description' => $this->description,
            'certificate' => $this->certificate != null ? new CertificateResource($this->certificate) : null
        ];
    }
}
