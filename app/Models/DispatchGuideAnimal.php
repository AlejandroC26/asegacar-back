<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatchGuideAnimal extends Model
{
    use HasFactory;

        
    protected $fillable = [
        'id_dispatch_guide',
        'id_daily_payroll',
        'amount'
    ];

    public function dailyPayroll() 
    { 
        return $this->belongsTo(DailyPayroll::class, 'id_daily_payroll'); 
    }
}
