<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyRoutes extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_route',
        'id_outlet',
        'id_vehicle',
        'quantity',
        'orders',
        'date'
    ];

    public function route()
    {
        return $this->belongsTo(Route::class, 'id_route');
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
