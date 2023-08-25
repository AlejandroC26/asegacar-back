<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormBenefitOrderResource extends JsonResource
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
            "id_master" => $this->id_master,
            'id_daily_payroll' => $this->id_daily_payroll,
            "id_outlet" => $this->dailyPayroll->outlet->id,
            "outlet" => $this->dailyPayroll->outlet->code,
            "code" => $this->dailyPayroll->code,
            
            "responsable" => $this->master->responsable->fullname,
            "date" => date_format(date_create($this->master->date), 'Y-m-d'),
            "created_at" => date_format(date_create($this->created_at), 'Y-m-d H:i:s a')
        ];
    }
}
