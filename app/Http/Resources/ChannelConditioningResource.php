<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChannelConditioningResource extends JsonResource
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
            'id_master' => $this->id_master,
            "date" => date_format(date_create($this->master->date), 'Y-m-d'),
            "supervised_by" => $this->master->supervised_by?->fullname,
            "verified_by" => $this->master->verified_by?->fullname,
            "responsable" => $this->responsable?->fullname,

            'id_antemortem_daily_record' => $this->id_antemortem_daily_record,
            "id_outlet" => $this->antemortem_daily_record->outlet->id,
            "outlet" => $this->antemortem_daily_record->outlet->code,
            "code" => $this->antemortem_daily_record->code,
            "skin" => $this->skin,
            "hair" => $this->hair,
            "hematoma" => $this->hematoma,
            "abscess" => $this->abscess,
            "parasite" => $this->parasite,
            "other" => $this->other,
            "correction" => $this->correction,
            "quantity" => $this->quantity,
        ];
    }
}
