<?php

namespace App\Http\Resources;

use App\Models\Person;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
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
            'id_persons' => $this->id_persons,
            'persons' => Person::find($this->id_persons)->fullname,
            'guide_number' => $this->guide_number,
            'signature_date' => date_format(date_create($this->signature_date), 'Y-m-d'),
            'signature' => $this->signature ?? 'N/A',
            'created_at' => date_format(date_create($this->created_at), 'Y-m-d H:i:s a')
        ];
    }
}
