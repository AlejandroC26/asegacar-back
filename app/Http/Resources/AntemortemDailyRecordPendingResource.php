<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AntemortemDailyRecordPendingResource extends JsonResource
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
            'id_color' => $this->id_color,
            'id_guide' => $this->id_guide,
            'id_gender' => $this->id_gender,
            'id_purpose' => $this->id_purpose,
            'id_age' => $this->id_age,
            'code' => $this?->code,
            'guide' => $this?->guide?->code,
            'date_entry' => $this->guide->date_entry,
            'time_entry' => $this->guide->time_entry,
            'gender' => $this->gender->name,
            'color' => $this->color->name,
            'age' => $this->age->description,
            'purpose' => $this->purpose->name,
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
