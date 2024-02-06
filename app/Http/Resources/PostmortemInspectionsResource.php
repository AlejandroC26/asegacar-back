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
            "responsable" => $this->responsable?->fullname,
            "date" => date_format(date_create($this->date), 'Y-m-d'),

            'id_daily_payroll' => $this->id_daily_payroll,
            "id_outlet" => $this->dailyPayroll->outlet->id,
            "outlet" => $this->dailyPayroll->outlet->code,
            "code" => $this->dailyPayroll->incomeForm->code,

            'id_head_cause' => $this->id_head_cause,
            'head' => $this->head?->name,
            'head_quantity' => $this->head_quantity,

            'id_small_ints_cause' => $this->id_small_ints_cause,
            'small_ints' => $this->small_ints?->name,
            'small_ints_quantity' => $this->small_ints_quantity,

            'id_large_ints_cause' => $this->id_large_ints_cause,
            'large_ints' => $this->large_ints?->name,
            'large_ints_quantity' => $this->large_ints_quantity,

            'id_oment_cause' => $this->id_oment_cause,
            'oment' => $this->oment?->name,
            'oment_quantity' => $this->oment_quantity,

            'id_renet_cause' => $this->id_oment_cause,
            'renet' => $this->renet?->name,
            'renet_quantity' => $this->renet_quantity,

            'id_callus_cause' => $this->id_callus_cause,
            'callus' => $this->callus?->name,
            'callus_quantity' => $this->callus_quantity,

            'id_liver_cause' => $this->id_liver_cause,
            'liver' => $this->liver?->name,
            'liver_quantity' => $this->liver_quantity,

            'id_lungs_cause' => $this->id_lungs_cause,
            'lungs' => $this->lungs?->name,
            'lungs_quantity' => $this->lungs_quantity,

            'id_legs_cause' => $this->id_legs_cause,
            'legs' => $this->legs?->name,
            'legs_quantity' => $this->legs_quantity,

            'id_hands_cause' => $this->id_hands_cause,
            'hands' => $this->hands?->name,
            'hands_quantity' => $this->hands_quantity,

            'id_udder_cause' => $this->id_udder_cause,
            'udder' => $this->udder?->name,
            'udder_quantity' => $this->udder_quantity,

            'id_kidney_cause' => $this->id_kidney_cause,
            'kidney' => $this->kidney?->name,
            'kidney_quantity' => $this->kidney_quantity,

            'id_heart_cause' => $this->id_heart_cause,
            'heart' => $this->heart?->name,
            'heart_quantity' => $this->heart_quantity,

            'id_booklet_cause' => $this->id_booklet_cause,
            'booklet' => $this->booklet?->name,
            'booklet_quantity' => $this->booklet_quantity,

            'id_white_viscera_cause' => $this->id_white_viscera_cause,
            'white_viscera' => $this->white_viscera?->name,
            'white_viscera_quantity' => $this->white_viscera_quantity,

            'id_red_viscera_cause' => $this->id_red_viscera_cause,
            'red_viscera' => $this->red_viscera?->name,
            'red_viscera_quantity' => $this->red_viscera_quantity,

            'id_destocking_cause' => $this->id_destocking_cause,
            'destocking' => $this->destocking?->name,
            'destocking_quantity' => $this->destocking_quantity,

            'id_canal_cause' => $this->id_canal_cause,
            'destocking' => $this->destocking?->name,
            'canal_quantity' => $this->canal_quantity,

            'other_organ' => $this->other_organ,
            'id_other_cause' => $this->id_other_cause,
            'other_cause' => $this->other_cause?->name,
            'other_quantity' => $this->other_quantity,
            'insp_ganglions' => $this->insp_ganglions,
        ];
    }
}
