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
            'id_master' => $this->id_master,
            "responsable" => $this->master->responsable?->fullname,
            "date" => date_format(date_create($this->master->date), 'Y-m-d'),
            "outlet" => $this->outlet->code,

            "id_gender" => $this->id_color,
            "id_color" => $this->id_color,

            "gender" => $this->gender->name,
            "color" => $this->color->name,

            'amount' => $this->amount,
            'special_order' => $this->special_order ?? 'N/A',
            //'created_at' => date_format(date_create($this->created_at), 'Y-m-d H:i:s a')
        ];
    }
}
