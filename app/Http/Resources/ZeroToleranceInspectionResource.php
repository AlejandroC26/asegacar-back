<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ZeroToleranceInspectionResource extends JsonResource
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
            "responsable" => $this->master->responsable?->fullname,

            'id_daily_payroll' => $this->id_daily_payroll,
            "id_outlet" => $this->dailyPayroll->outlet->id,
            "outlet" => $this->dailyPayroll->outlet->code,
            "code" => $this->dailyPayroll->code,
            
            "milk" => $this->milk,            
            "fecal_matter" => $this->fecal_matter,
            "rumen_content" => $this->rumen_content,
            "corrective_actions" => $this->corrective_actions,
            "quantity" => $this->quantity,            
        ];
    }
}
