<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatchGuide extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'code',
        'sacrifice_date',
        'average_temperature',
        'closing_date',
        'closing_time',
        'dispatch_time',
        'id_outlet',
        'id_invima_code',
        'id_vehicle'
    ];

    public function invimaCode()
    {
        return $this->belongsTo(InvimaCode::class, 'id_invima_code');
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class, 'id_outlet');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'id_vehicle');
    }
}
