<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DailyRouteResource extends JsonResource
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
            "id_route" => $this->route->id,
            "route" => $this->route->name,
            'id_daily_payroll' => $this->id_daily_payroll,
            "id_outlet" => $this->daily_payroll->outlet->id,
            "outlet" => $this->daily_payroll->outlet->code,
            "# animal" => $this->daily_payroll->code,
            "quantity" => $this->quantity,
            "orders" => $this->orders,
            "date" => date_format(date_create($this->date), 'Y-m-d'),
            "created_at" => date_format(date_create($this->created_at), 'Y-m-d H:i:s a')
        ];
    }
}
