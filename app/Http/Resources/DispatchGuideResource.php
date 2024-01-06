<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DispatchGuideResource extends JsonResource
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
            "id" => $this->id,
            "code" => $this->code,
            'dispatch_time' => $this->dispatch_time,
            'id_outlet' => $this->id_outlet,
            "outlet" => $this->outlet->code,
            'average_temperature' => $this->average_temperature,
            "id_invima_code" => $this->id_invima_code,
            "id_vehicle" => $this->id_vehicle,
            "vehicle" => $this->vehicle->plate,
            "closing_date" => date_format(date_create($this->closing_date), 'Y-m-d'),
            'closing_time' => date_format(date_create($this->closing_time), 'H:i'),
            "sacrifice_date" => date_format(date_create($this->sacrifice_date), 'Y-m-d'),
        ];
    }
}
