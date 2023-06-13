<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VisceraDispatchResource extends JsonResource
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
            "elaborated_by" => $this->master->responsable?->fullname,
            "supervised_by" => $this->master->supervised_by?->fullname,
            'id_antemortem_daily_record' => $this->id_antemortem_daily_record,
            "id_outlet" => $this->antemortem_daily_record->outlet->id,
            "outlet" => $this->antemortem_daily_record->outlet->code,
            "code" => $this->antemortem_daily_record->code,
            
            "head" => $this->head,
            "small_ints" => $this->small_ints,
            "large_ints" => $this->large_ints,
            "panolon" => $this->panolon,
            "rennet" => $this->rennet,
            "callus" => $this->callus,
            "liver" => $this->liver,
            "lung" => $this->lung,
            "legs" => $this->legs,
            "hands" => $this->hands,
            "udders" => $this->udders,
            "booklet" => $this->booklet,
            "observations" => $this->observations,
        ];
    }
}
