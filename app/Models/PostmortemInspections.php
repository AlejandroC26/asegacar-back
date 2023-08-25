<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostmortemInspections extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_master',
        'id_daily_payroll',
        'id_intestines_cause',
        'intestines_quantity',
        'id_livers_cause',
        'liver_quantity',
        'id_lungs_cause',
        'lungs_quantity',
        'id_udders_cause',
        'udders_quantity',
        'id_legs_cause',
        'legs_quantity',
        'id_purges_cause',
        'purges_quantity',
        'other_organ',
        'id_other_cause',
        'other_quantity',
        'insp_ganglions',
    ];
    public function master() { return $this->belongsTo(MasterTable::class, 'id_master'); }
    public function dailyPayroll() { return $this->belongsTo(DailyPayroll::class, 'id_daily_payroll'); }
    public function intestines_cause() { return $this->belongsTo(Causes::class, 'id_intestines_cause'); }
    public function livers_cause() { return $this->belongsTo(Causes::class, 'id_livers_cause'); }
    public function lungs_cause() { return $this->belongsTo(Causes::class, 'id_lungs_cause'); }
    public function legs_cause() { return $this->belongsTo(Causes::class, 'id_legs_cause'); }
    public function purges_cause() { return $this->belongsTo(Causes::class, 'id_purges_cause'); }
    public function other_cause() { return $this->belongsTo(Causes::class, 'id_other_cause'); }
    
}
