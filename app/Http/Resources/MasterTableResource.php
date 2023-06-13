<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MasterTableResource extends JsonResource
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
            "id" => $this->id,
            "date" => date_format(date_create($this->date), 'Y-m-d'),
            "id_responsable" => $this->id_responsable,
            "id_master_type" => $this->id_master_type,
            "responsable" => $this->responsable?->fullname ?? 'N/A',
            "id_verified_by" => $this->id_verified_by,
            "verified_by" => $this->verified_by?->fullname ?? 'N/A',
            "id_supervised_by" => $this->id_supervised_by,
            "supervised_by" => $this->supervised_by?->fullname ?? 'N/A',
            "id_elaborated_by" => $this->id_elaborated_by,
            "elaborated_by" => $this->elaborated_by?->fullname ?? 'N/A',
            "species" => $this->species ?? 'N/A',
            "type" => $this->type->name,
            "created_at" => date_format(date_create($this->created_at), 'Y-m-d H:i:s a')
        ];
    }

    public static function toSelect($data)
    {
        $aResponse = [];
        foreach ($data as $key => $element) {
            $aResponse[$key]['id'] = $element->id;
            $aResponse[$key]['name'] = date_format(date_create($element->date), 'Y-m-d').'  '.$element->responsable?->fullname;
        }
        return collect($aResponse);
    }
    
}
