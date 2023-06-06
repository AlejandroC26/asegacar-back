<?php

namespace App\Http\Resources;

use App\Models\City;
use App\Models\Person;
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
            'owner' => Person::find($this->id_owner)->fullname,
            'buyer' => Person::find($this->id_buyer)->fullname,
            'establishment_name' => $this->establishment_name,
            'source' => City::find($this->id_source)->name,
            'destination' => City::find($this->id_destination)->name,
            'created_at' => date_format(date_create($this->created_at), 'Y-m-d H:i:s a')
        ];
    }
}
