<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
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
            "plate" => $this->plate,
            "driver_name" => $this->driver_name,
            "driver_document" => $this->driver_document,
            "refrigerated" => $this->refrigerated,
            "isothermal" => $this->isothermal,
            "temperature" => $this->temperature,
            "created_at" => date_format(date_create($this->created_at), 'Y-m-d H:i:s a')
        ];
    }
}
