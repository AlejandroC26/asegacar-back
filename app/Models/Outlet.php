<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'customer',
        'primary_phone',
        'secondary_phone',
        'establishment_name',
        'establishment_address',
        'id_city'
    ];

    public function city() { 
        return $this->belongsTo(City::class, 'id_city'); 
    }

    public function dailyPayrolls() {
        return $this->hasMany(DailyPayroll::class, 'id_outlet');
    }

    public function dispatchGuideAnimals() {
        return $this->hasManyThrough(DispatchGuideAnimal::class, DailyPayroll::class, 'id_outlet', 'id_daily_payroll', 'id', 'id');
    }
}
