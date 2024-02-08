<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyPayrollMaster extends Model
{
    use HasFactory;
    
    public $table = 'daily_payroll_master';
    
    protected $fillable = [
        'date',
        'state',
        'id_administrative_assistant',
        'id_quality_assistant',
        'id_operational_manager',
        'id_assistant_veterinarian',
    ];

    public function administrative_assistant() { 
        return $this->belongsTo(Person::class, 'id_administrative_assistant'); 
    }

    public function quality_assistant() { 
        return $this->belongsTo(Person::class, 'id_quality_assistant'); 
    }

    public function operational_manager() { 
        return $this->belongsTo(Person::class, 'id_operational_manager'); 
    }

    public function assistant_veterinarian() { 
        return $this->belongsTo(Person::class, 'id_assistant_veterinarian'); 
    }

    public function incomeForms() {
        return $this->hasMany(IncomeForm::class, 'id_dp_master');
    }

    public function dailyPayrolls() {
        return $this->incomeForms->map(function($incomeForm) {
            return $incomeForm->dailyPayroll;
        })->filter(function($item) {
            return !is_null($item);
        })->values();
    }
}
