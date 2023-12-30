<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class IncomeFormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $guide = $this->incomeForms[0]->guide;
        return [
            'id' => $this->id,
            "responsable" => $this->responsable?->fullname,
            "date" => date_format(date_create($this->date), 'Y-m-d'),
            "guide" => $guide->code,
            "consecutive" => $guide->consecutive,
            "entries" => count($this->incomeForms)
        ];
    }
}
