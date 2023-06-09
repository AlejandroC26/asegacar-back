<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ZeroGutsToleranceResource extends JsonResource
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
            "species" => $this->master->species,
            "elaborated_by" => $this->master->elaborated_by?->fullname,
            "verified_by" => $this->master->verified_by?->fullname,

            'id_antemortem_daily_record' => $this->id_antemortem_daily_record,
            "id_outlet" => $this->antemortem_daily_record->outlet->id,
            "outlet" => $this->antemortem_daily_record->outlet->code,
            "code" => $this->antemortem_daily_record->code,
            "organ" => $this->organ,
            "fecal_matter" => $this->fecal_matter,
            "resume" => $this->resume,
            "hide" => $this->hide,
            "hair" => $this->hair,
            "hem" => $this->hem,
            "abscess" => $this->abscess,
            "parasite" => $this->parasite,
            "others" => $this->others,
            "correction" => $this->correction,
            "quantity" => $this->quantity,
            "observations" => $this->observations,
        ];
    }
}
