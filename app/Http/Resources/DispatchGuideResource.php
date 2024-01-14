<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DispatchGuideResource extends JsonResource
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
            "code" => $this->code,
            'dispatch_time' => $this->dispatch_time,
            'id_outlet' => $this->id_outlet,
            "outlet" => $this->outlet->code,
            'average_temperature' => $this->average_temperature,
            "id_invima_code" => $this->id_invima_code,
            "id_vehicle" => $this->id_vehicle,
            "vehicle" => $this->vehicle->plate,
            "white_viscera" => $this->white_viscera ?? '',
            "red_viscera" => $this->red_viscera ?? '',
            "heads" => $this->heads ?? '',
            "legs" => $this->legs ?? '',
            "others" => $this->others ?? '',
            "approved" => $this->approved ?? '',
            "observations" => $this->observations ?? '',
            "closing_date" => date_format(date_create($this->closing_date), 'Y-m-d'),
            'closing_time' => date_format(date_create($this->closing_time), 'H:i'),
            "sacrifice_date" => date_format(date_create($this->sacrifice_date), 'Y-m-d'),
        ];
    }

    public static function toShow($that)
    {
        $response = [
            "id" => $that->id,
            "code" => $that->code,
            'dispatch_time' => $that->dispatch_time,
            'id_outlet' => $that->id_outlet,
            "outlet" => $that->outlet->code,
            'average_temperature' => $that->average_temperature,
            "id_invima_code" => $that->id_invima_code,
            "id_vehicle" => $that->id_vehicle,
            "vehicle" => $that->vehicle->plate,
            "white_viscera" => $that->white_viscera ?? '',
            "red_viscera" => $that->red_viscera ?? '',
            "heads" => $that->heads ?? '',
            "legs" => $that->legs ?? '',
            "others" => $that->others ?? '',
            "approved" => $that->approved ?? '',
            "observations" => $that->observations ?? '',
            "animals" => $that->dispatchGuideAnimals->map(function($oAnimal) {
                $oResponse['id'] = $oAnimal->id_daily_payroll;
                $oResponse['code'] = $oAnimal->dailyPayroll->incomeForm->code;
                $oResponse['product_type'] = $oAnimal->dailyPayroll->productType->name;
                $oResponse['special_order'] = $oAnimal->dailyPayroll->special_order;
                $oResponse['amount'] = $oAnimal->dailyPayroll->dispatchGuideAnimal->sum('amount');
                return $oResponse;
            }),
            "closing_date" => date_format(date_create($that->closing_date), 'Y-m-d'),
            'closing_time' => date_format(date_create($that->closing_time), 'H:i'),
            "sacrifice_date" => date_format(date_create($that->sacrifice_date), 'Y-m-d'),
        ];
        return (object)$response;
    }
}
