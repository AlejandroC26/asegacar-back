<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZeroToleranceInspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_master',
        'id_daily_payroll',
        'milk',
        'fecal_matter',
        'rumen_content',
        'corrective_actions',
        'quantity',
    ];

    public function master() { return $this->belongsTo(MasterTable::class, 'id_master'); }
    public function dailyPayroll() { return $this->belongsTo(DailyPayroll::class, 'id_daily_payroll'); }
}
