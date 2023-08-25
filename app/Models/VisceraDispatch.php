<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisceraDispatch extends Model
{
    use HasFactory;
    public $table = 'viscera_dispatch';

    protected $fillable = [
        'id_master',
        'id_daily_payroll',
        'head',
        'small_ints',
        'large_ints',
        'panolon',
        'rennet',
        'callus',
        'liver',
        'lung',
        'legs',
        'hands',
        'udders',
        'booklet',
        'observations',
    ];

    public function master() { return $this->belongsTo(MasterTable::class, 'id_master'); }
    public function dailyPayroll() { return $this->belongsTo(DailyPayroll::class, 'id_daily_payroll'); }
}
