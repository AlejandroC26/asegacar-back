<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GuideResource extends JsonResource
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
            'code' => $this->code,
            'date_entry' => $this->date_entry,
            'time_entry' => $this->time_entry,
            'id_source' => $this->id_source,
            'id_destination' => $this->id_destination,
            'id_owner' => $this->id_owner,
            'id_buyer' => $this->id_buyer,
            'owner' => $this->owner->fullname,
            'buyer' => $this->buyer->fullname,
            'establishment_name' => $this->establishment_name,
            'state' => $this->state,
            'source' => $this->source->name,
            'destination' => $this->destination->name,
            'id_department_source' => $this->source->id_department,
            'id_department_destination' => $this->destination->id_department,
            'created_at' => date_format(date_create($this->created_at), 'Y-m-d H:i:s a')
        ];
    }
}
