<?php

namespace App\Http\Resources;

use App\Models\AntemortemInspection;
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
            'corral_entry' => date_format(date_create($this->corral_entry), 'H:i'),
            'id_veterinary' => $this->id_veterinary,
            'rest_time' => $this->rest_time,
            'findings_and_observations' => $this->findings_and_observations ?? '',
            'final_dictament' => $this->final_dictament ?? '',
            'cause_for_seizure' => $this->cause_for_seizure ?? ''
        ];
    }

    public static function toShow($that) 
    {
        $incomes = AntemortemInspection::where('date', $that->date)->whereHas('dailyPayroll.incomeForm', function($query) use ($that) {
            $query->where('id_guide', $that->dailyPayroll->incomeForm->id_guide);
        })->get();
        return [
            'date' => date_format(date_create($that->date), 'Y-m-d'),
            'id_guide' => $that->dailyPayroll->incomeForm->id_guide,
            'guide' => $that->dailyPayroll->incomeForm->guide->code,
            'entries' => $incomes->map(function($income) {
                $response['id'] = $income->id;
                $response['code'] = $income->dailyPayroll->incomeForm->code;
                $response['corral_number'] = $income->corral_number;
                $response['corral_entry'] = $income->corral_entry;
                $response['rest_time'] = $income->rest_time;
                $response['findings_and_observations'] = $income->findings_and_observations;
                $response['final_dictament'] = $income->final_dictament;
                $response['cause_for_seizure'] = $income->cause_for_seizure;
                return $response;
            })
        ];
    }
}
