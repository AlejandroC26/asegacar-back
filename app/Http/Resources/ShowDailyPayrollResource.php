<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShowDailyPayrollResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $guide = $this->incomeForms[0]->guide;
        return [
            'id_dp_master' => $this->id,
            "responsable" => $this->responsable?->fullname,
            "date" => date_format(date_create($this->date), 'Y-m-d'),
            'id_guide' => $guide->id,
            "guide" => $guide->code,
            "entries" => $this->dailyPayrolls->map(function($oDailyPayroll) {
                $oResponse['code'] = $oDailyPayroll->incomeForm->code;
                $oResponse['id_product_type'] = $oDailyPayroll->id_product_type;
                $oResponse['id_outlet'] = $oDailyPayroll->id_outlet;
                $oResponse['number'] = $oDailyPayroll->number;
                $oResponse['sacrifice_date'] = $oDailyPayroll->sacrifice_date;
                $oResponse['special_order'] = $oDailyPayroll->special_order;
                return $oResponse;
            })
        ];
    }
}
