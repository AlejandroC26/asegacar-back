<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyRoutes extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_route',
        'id_antemortem_daily_record',
        'quantity',
        'orders',
        'date'
    ];

    public function route()
    {
        return $this->belongsTo(Route::class, 'id_route');
    }

    public function antemortem_daily_record()
    {
        return $this->belongsTo(AntemortemDailyRecord::class, 'id_antemortem_daily_record');
    }
}
