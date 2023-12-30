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
        'id_responsable',
        'state'
    ];

    public function responsable() { 
        return $this->belongsTo(Person::class, 'id_responsable'); 
    }

    public function incomeForms() {
        return $this->hasMany(IncomeForm::class, 'id_dp_master');
    }

    public function dailyPayrolls() {
        return $this->hasManyThrough(DailyPayroll::class, IncomeForm::class, 'id_dp_master', 'id_income_form', 'id', 'id');
    }
}
