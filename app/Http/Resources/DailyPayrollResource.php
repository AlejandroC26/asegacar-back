<?php

namespace App\Http\Resources;

use App\Models\Outlet;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class DailyPayrollResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $genders = DB::table('daily_payroll_genders')
            ->leftJoin('genders', 'genders.id', 'daily_payroll_genders.id_gender')
            ->selectRaw('GROUP_CONCAT(genders.name SEPARATOR ", ") as data')
            ->where(['id_daily_payroll' => $this->id])
            ->groupBy('id_daily_payroll')
            ->first();

        $colors = DB::table('daily_payroll_colors')
            ->leftJoin('colors', 'colors.id', 'daily_payroll_colors.id_color')
            ->selectRaw('GROUP_CONCAT(colors.name SEPARATOR ", ") as data')
            ->where(['id_daily_payroll' => $this->id])
            ->groupBy('id_daily_payroll')
            ->first();

        return [
            'id' => $this->id,
            'outlet' => Outlet::find($this->id_outlet)->code,
            'total_males' => $this->total_males,
            'total_females' => $this->total_females,
            'colors' => $colors->data,
            'genders' => $genders->data,
            'special_order' => $this->special_order ?? 'N/A',
            'benefit_date' => date_format(date_create($this->benefit_date), 'Y-m-d'),
            //'created_at' => date_format(date_create($this->created_at), 'Y-m-d H:i:s a')
        ];
    }
}
