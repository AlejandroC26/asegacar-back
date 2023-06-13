<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostmortemInspectionsResource extends JsonResource
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
            "responsable" => $this->master->responsable->fullname,
            "date" => date_format(date_create($this->master->date), 'Y-m-d'),

            'id_antemortem_daily_record' => $this->id_antemortem_daily_record,
            "id_outlet" => $this->antemortem_daily_record->outlet->id,
            "outlet" => $this->antemortem_daily_record->outlet->code,

            'id_intestines_cause' => $this->id_intestines_cause,
            'intestines_cause' => $this->intestines_cause?->name,
            'intestines_quantity' => $this->intestines_quantity,

            'id_livers_cause' => $this->id_livers_cause,
            'livers_cause' => $this->livers_cause?->name,
            'liver_quantity' => $this->liver_quantity,

            'id_lungs_cause' => $this->id_lungs_cause,
            'lungs_cause' => $this->lungs_cause?->name,
            'lungs_quantity' => $this->lungs_quantity,

            'id_udders_cause' => $this->id_udders_cause,
            'udders_cause' => $this->udders_cause?->name,
            'udders_quantity' => $this->udders_quantity,

            'id_legs_cause' => $this->id_legs_cause,
            'legs_cause' => $this->legs_cause?->name,
            'legs_quantity' => $this->legs_quantity,

            'id_purges_cause' => $this->id_purges_cause,
            'purges_cause' => $this->purges_cause?->name,
            'purges_quantity' => $this->purges_quantity,

            'other_organ' => $this->other_organ,
            'id_other_cause' => $this->id_other_cause,
            'other_cause' => $this->other_cause?->name,
            'other_quantity' => $this->other_quantity,
            'insp_ganglions' => $this->insp_ganglions,
            'created_at' => date_format(date_create($this->created_at), 'Y-m-d H:i:s a')
        ];
    }
}
