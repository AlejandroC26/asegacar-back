<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowDailyPayrollResource extends JsonResource
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
            "responsable" => $this->responsable?->fullname,
            "date" => date_format(date_create($this->date), 'Y-m-d'),
            'id_guide' => $this->id_guide,
            "guide" => $this->guide->code,
            "entries" => $this->dailyPayrolls
        ];
    }
}
