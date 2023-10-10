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
            'id_guide' => $this->dailyPayroll->master->id_guide,
            'guide' => $this->dailyPayroll->master->guide->code,
            'id_daily_payroll' => $this->id_daily_payroll,
            'animal_code' => $this->dailyPayroll->code,
            'corral_entry' => date_format(date_create($this->corral_entry), 'H:i'),
            'id_veterinary' => $this->id_veterinary,
            'veterinary' => $this->veterinary->person->fullname ?? '',
            'time_entry' => $this->time_entry,
            'time_off' => self::timeOff($this->corral_entry, $this->time_entry)
        ];
    }

    static function timeOff($fecha, $hora) {
        $horaInicio = DateTime::createFromFormat('H:i:s', $fecha);
        $horaFin = DateTime::createFromFormat('H:i:s', $hora);
        
        $diferencia = $horaInicio->diff($horaFin);
        
        $horas = $diferencia->h;
        $minutos = $diferencia->i;
        
        if ($horas > 0) {
            $horas = 24 - $horas;
            return $horas . 'h';
        } else {
            return $minutos . 'm';
        }
    }
}