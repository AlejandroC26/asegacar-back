<?php

namespace App\Http\Resources;

use App\Models\Age;
use App\Models\City;
use App\Models\Outlet;
use App\Models\Person;
use App\Models\Purpose;
use Illuminate\Http\Resources\Json\JsonResource;

class IncomeResource extends JsonResource
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
            'date_entry' => $this->date_entry,
            'code' => $this->code,
            'guide_number' => $this->guide_number,
            'time_entry' => $this->time_entry,
            'total_males' => $this->total_males,
            'total_females' => $this->total_females,
            'age' => Age::find($this->id_age)->description,
            'gender' => $this->gender,
            'purpose' => Purpose::find($this->id_purpose)->name,
            'color' => $this->color,
            'outlet' => Outlet::find($this->id_outlet)->description,
            'yard_sacrificed_time' => $this->yard_sacrificed_time,
            'benefit_date' => $this->benefit_date,
            'id_owner' => $this->id_owner,
            'owner' => Person::find($this->id_owner)->fullname,
            'id_buyer' => $this->id_owner,
            'buyer' => Person::find($this->id_buyer)->fullname,
            'id_age' => $this->id_age,
            'id_purpose' => $this->id_purpose,
            'id_outlet' => $this->id_outlet,
            'id_city' => $this->id_city,
            'city' => City::find($this->id_city)->name,
            'created_at' => date_format(date_create($this->created_at), 'Y-m-d H:i:s a')
        ];
    }
}
