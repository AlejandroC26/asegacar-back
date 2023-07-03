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
            'id_antemortem_daily_record' => $this->id_antemortem_daily_record,
            "id_outlet" => $this->antemortem_daily_record->outlet->id,
            "outlet" => $this->antemortem_daily_record->outlet->code,
            "# animal" => $this->antemortem_daily_record->code,
            "quantity" => $this->quantity,
            "orders" => $this->orders,
            "date" => date_format(date_create($this->date), 'Y-m-d'),
            "created_at" => date_format(date_create($this->created_at), 'Y-m-d H:i:s a')
        ];
    }
}
