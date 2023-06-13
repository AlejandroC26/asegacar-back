<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeizureComparison extends Model
{
    use HasFactory;

    public $table = 'seizure_comparison';

    protected $fillable = [
        'id_master',
        'id_antemortem_daily_record',
        'small_ints',
        'large_ints',
        'liver',
        'lung',
        'udders',
        'head',
        'hands',
        'legs',
        'others',
        'destocking',
    ];

    public function master() { return $this->belongsTo(MasterTable::class, 'id_master'); }
    public function antemortem_daily_record() { return $this->belongsTo(AntemortemDailyRecord::class, 'id_antemortem_daily_record'); }
}
