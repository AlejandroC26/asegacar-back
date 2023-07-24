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
        return [
            'id' => $this->id,
            "responsable" => $this->responsable?->fullname,
            "date" => date_format(date_create($this->date), 'Y-m-d'),
            "entries" => count($this->dailyPayrolls)
        ];
    }

    public static function toSelect($data)
    {
        $aResponse = [];
        foreach ($data as $key => $element) {
            $aResponse[$key]['id'] = $element->id;
            $aResponse[$key]['name'] = date_format(date_create($element->date), 'Y-m-d').'  '.$element->responsable?->fullname;
        }
        return collect($aResponse);
    }
}
