<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyRoutes extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_route',
        'id_daily_payroll',
        'quantity',
        'orders',
        'date'
    ];

    public function route()
    {
        return $this->belongsTo(Route::class, 'id_route');
    }

    public function daily_payroll()
    {
        return $this->belongsTo(DailyPayroll::class, 'id_daily_payroll');
    }
}
