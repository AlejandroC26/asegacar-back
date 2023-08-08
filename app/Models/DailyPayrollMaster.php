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
        'id_guide',
        'state'
    ];

    public function guide() { 
        return $this->belongsTo(Guide::class, 'id_guide'); 
    }

    public function responsable() { 
        return $this->belongsTo(Person::class, 'id_responsable'); 
    }

    public function dailyPayrolls() {
        return $this->hasMany(DailyPayroll::class, 'id_dp_master', 'id');
    }
}
