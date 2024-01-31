<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmergencyCoilEntryResource extends JsonResource
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
            'date' => date_format(date_create($this->created_at), 'Y-m-d'),
            'time' => date('H:i', strtotime($this->time)),
            'id_supervisor' => $this->id_supervisor,
            'supervisor' => $this->supervisor->person->fullname,
            'id_responsable' => $this->id_responsable,
            'responsable' => $this->responsable->person->fullname,
            'id_veterinary' => $this->id_veterinary,
            'veterinary' => $this->veterinary->person->fullname,
            'id_owner' => $this->id_owner,
            'owner' => $this->owner->person->fullname,
            'iron' => $this->iron,
            'corral_location' => $this->corral_location,
            'id_location' => $this->id_location,
            'location' => $this->location->name,
            'id_department_source' => $this->location->id_department,
            'id_guide' => $this->dailyPayroll->incomeForm->id_guide,
            'guide' => $this->dailyPayroll->incomeForm->guide->code,
            'id_daily_payroll' => $this->id_daily_payroll,
            'id_gender' => $this->dailyPayroll->incomeForm->id_gender,
            'animal_code' => $this->dailyPayroll->incomeForm->code,
            'weight' => $this->weight,
            'temperature' => $this->temperature,
            'heart_frequency' => $this->heart_frequency,
            'respiratory_frequency' => $this->respiratory_frequency,
            'findings' => $this->findings,
            'observations' => $this->observations
        ];
    }
}
