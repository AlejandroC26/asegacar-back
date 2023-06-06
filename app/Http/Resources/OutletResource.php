<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OutletResource extends JsonResource
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
            'customer' => $this->customer,
            'primary_phone' => $this->primary_phone,
            'secondary_phone' => $this->secondary_phone,
            'establishment_name' => $this->establishment_name,
            'establishment_address' => $this->establishment_address,
            'created_at' => date_format(date_create($this->created_at), 'Y-m-d H:i:s a')
        ];
    }
}
