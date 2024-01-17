<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class AntemortemInspectionResource extends JsonResource
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
            'date' => date_format(date_create($this->date), 'Y-m-d'),
            'corral_number' => $this->corral_number,
            'id_guide' => $this->dailyPayroll->incomeForm->id_guide,
            'guide' => $this->dailyPayroll->incomeForm->guide->code,
            'animal_code' => $this->dailyPayroll->incomeForm->code,
            'id_daily_payroll' => $this->id_daily_payroll,
            'veterinary' => $this->veterinary->person->fullname ?? '',
            'time_entry' => date_format(date_create($this->time_entry), 'H:i'),
            'corral_entry' => date_format(date_create($this->corral_entry), 'H:i'),
            'id_veterinary' => $this->id_veterinary,
            'rest_time' => $this->rest_time
        ];
    }
}
