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
            "responsable" => $this->responsable?->fullname,
            "date" => date_format(date_create($this->date), 'Y-m-d'),

            'id_daily_payroll' => $this->id_daily_payroll,
            "id_outlet" => $this->dailyPayroll->outlet?->id,
            "outlet" => $this->dailyPayroll->outlet?->code,
            "code" => $this->dailyPayroll->incomeForm->code,
            'head_quantity' => $this->head_quantity,
            'small_ints_quantity' => $this->small_ints_quantity,
            'large_ints_quantity' => $this->large_ints_quantity,
            'oment_quantity' => $this->oment_quantity,
            'renet_quantity' => $this->renet_quantity,
            'callus_quantity' => $this->callus_quantity,
            'liver_quantity' => $this->liver_quantity,
            'lungs_quantity' => $this->lungs_quantity,
            'legs_quantity' => $this->legs_quantity,
            'hands_quantity' => $this->hands_quantity,
            'udder_quantity' => $this->udder_quantity,
            'kidney_quantity' => $this->kidney_quantity,
            'heart_quantity' => $this->heart_quantity,
            'booklet_quantity' => $this->booklet_quantity,
            'white_viscera_quantity' => $this->white_viscera_quantity,
            'red_viscera_quantity' => $this->red_viscera_quantity,
            'destocking_quantity' => $this->destocking_quantity,
            'canal_quantity' => $this->canal_quantity,
            'other_organ' => $this->other_organ,
            'other_quantity' => $this->other_quantity,
        ];
    }
}
