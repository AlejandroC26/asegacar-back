<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InspectionSuspiciousAnimalResource extends JsonResource
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
            'id_guide' => $this->dailyPayroll?->incomeForm?->id_guide,
            'guide' => $this->dailyPayroll?->incomeForm?->guide->code,
            "code" => $this->dailyPayroll->incomeForm->code,
            'id_daily_payroll' => $this->id_daily_payroll,
            'findings_and_observations' => $this->findings_and_observations ?? '',
            'decision' => $this->decision ?? '',
            'cause_forfeiture' => $this->cause_forfeiture ?? '',
            'corral' => $this->corral,
        ];
    }
}
