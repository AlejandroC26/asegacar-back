<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionSuspiciousAnimal extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_daily_payroll',
        'findings_and_observations',
        'decision',
        'cause_forfeiture',
        'corral'
    ];

    public function dailyPayroll() { 
        return $this->belongsTo(DailyPayroll::class, 'id_daily_payroll'); 
    }
}
