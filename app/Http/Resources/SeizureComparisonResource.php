<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SeizureComparisonResource extends JsonResource
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
            "responsable" => $this->master->responsable?->fullname,
            "supervised_by" => $this->master->supervised_by?->fullname,

            "small_ints" => $this->small_ints,
            "large_ints" => $this->large_ints,
            "liver" => $this->liver,
            "lung" => $this->lung,
            "udders" => $this->udders,
            "head" => $this->head,
            "hands" => $this->hands,
            "legs" => $this->legs,
            "others" => $this->others,
            "destocking" => $this->destocking,
        ];
    }
}
