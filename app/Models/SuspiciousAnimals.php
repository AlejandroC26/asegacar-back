<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuspiciousAnimals extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'id_supervisor',
        'id_responsable',
        'id_veterinary',
        'id_owner',
        'iron',
        'corral_location',
        'id_location',
        'id_daily_payroll',
        'weight',
        'temperature',
        'heart_frequency',
        'respiratory_frequency',
        'findings',
        'observations',
    ];

    public function supervisor () { 
        return $this->belongsTo(User::class, 'id_supervisor'); 
    }

    public function responsable () { 
        return $this->belongsTo(User::class, 'id_responsable'); 
    }

    public function veterinary () { 
        return $this->belongsTo(User::class, 'id_veterinary'); 
    }

    public function owner () { 
        return $this->belongsTo(User::class, 'id_owner'); 
    }
    
    public function dailyPayroll() 
    { 
        return $this->belongsTo(DailyPayroll::class, 'id_daily_payroll'); 
    }
    
    public function location() { 
        return $this->belongsTo(City::class, 'id_location'); 
    }
}
