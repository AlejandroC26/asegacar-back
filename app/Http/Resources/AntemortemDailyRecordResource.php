<?php

namespace App\Http\Resources;

use App\Models\Age;
use App\Models\Color;
use App\Models\Gender;
use App\Models\Guide;
use App\Models\Outlet;
use App\Models\Purpose;
use Illuminate\Http\Resources\Json\JsonResource;

class AntemortemDailyRecordResource extends JsonResource
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
            'id_color' => $this->id_color,
            'id_guide' => $this->id_guide,
            'id_gender' => $this->id_gender,
            'id_purpose' => $this->id_purpose,
            'code' => $this->code,
            'guide' => Guide::find($this->id_guide)->code,
            'date_entry' => Guide::find($this->id_guide)->date_entry,
            'time_entry' => Guide::find($this->id_guide)->time_entry,
            'gender' => Gender::find($this->id_gender)->name,
            'color' => Color::find($this->id_color)->name,
            'age' => Age::find($this->id_age)->description,
            'outlet' => Outlet::find($this->id_outlet)->code ?? '0',
            'purpose' => Purpose::find($this->id_purpose)->name,
            'sacrifice_date' => $this->sacrifice_date ? date_format(date_create($this->sacrifice_date), 'Y-m-d') : 'N/A',
            'created_at' => date_format(date_create($this->created_at), 'Y-m-d H:i:s a')
        ];
    }
}
