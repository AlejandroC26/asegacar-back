<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AntemortemDailyRecordResource extends JsonResource
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
            'id_outlet' => $this->id_outlet,
            'outlet' => $this->outlet->code,
            'id_color' => $this->incomeForm->id_color,
            'id_guide' => $this->incomeForm->id_guide,
            'id_gender' => $this->incomeForm->id_gender,
            'id_purpose' => $this->incomeForm->id_purpose,
            'id_age' => $this->incomeForm->id_age,
            'code' => $this->incomeForm->code,
            'guide' => $this->incomeForm->guide->code,
            'date_entry' => $this->incomeForm->guide->date_entry,
            'time_entry' => $this->incomeForm->guide->time_entry,
            'gender' => $this->incomeForm->gender->name,
            'color' => $this->incomeForm->color->name,
            'age' => $this->incomeForm->age->description,
            'purpose' => $this->incomeForm->purpose->name,
        ];
    }

    public static function toOutletSelect($data)
    {
        $aResponse = [];
        foreach ($data as $key => $outlet) {
            $aResponse[$key]['id'] = $outlet->outlet->id;
            $aResponse[$key]['name'] = $outlet->outlet->code;
            $aResponse[$key]['id_outlet'] = $outlet->id_outlet;
        }
        return collect($aResponse);
    }
}
