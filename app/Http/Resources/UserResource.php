<?php

namespace App\Http\Resources;

use App\Models\Person;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'person' => Person::find($this->id_person)->fullname,
            'position' => $this->position,
            'login' => $this->login,
            'created_at' => date_format(date_create($this->created_at), 'Y-m-d H:i:s a')
        ];
    }
}
