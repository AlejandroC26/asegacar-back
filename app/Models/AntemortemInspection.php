<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntemortemInspection extends Model
{
    use HasFactory;

    public $table = 'antemortem_inspection';

    protected $fillable = [
        'date',
        'corral_number',
        'id_daily_payroll',
        'corral_entry',
        'id_veterinary',
        'rest_time',
        'findings_and_observations',
        'final_dictament',
        'cause_for_seizure'
    ];
    
    public function dailyPayroll() 
    { 
        return $this->belongsTo(DailyPayroll::class, 'id_daily_payroll'); 
    }

    public function veterinary()
    {
        return $this->belongsTo(User::class, 'id_veterinary');
    }
}
