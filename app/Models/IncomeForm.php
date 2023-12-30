<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'id_dp_master',
        'id_guide',
        'id_gender',
        'id_color',
        'id_age',
        'id_purpose',
    ];

    public function guide() { 
        return $this->belongsTo(Guide::class, 'id_guide'); 
    }

    public function master() 
    { 
        return $this->belongsTo(DailyPayrollMaster::class, 'id_dp_master'); 
    }
    public function gender() 
    { 
        return $this->belongsTo(Gender::class, 'id_gender'); 
    }
    public function color() 
    { 
        return $this->belongsTo(Color::class, 'id_color'); 
    }
    public function age() 
    { 
        return $this->belongsTo(Age::class, 'id_age'); 
    }
    public function purpose() 
    { 
        return $this->belongsTo(Purpose::class, 'id_purpose'); 
    }
    public function dailyPayroll() 
    { 
        return $this->hasOne(DailyPayroll::class, 'id_income_form'); 
    }
}
