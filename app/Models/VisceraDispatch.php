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
        'id_antemortem_daily_record',
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
    public function antemortem_daily_record() { return $this->belongsTo(AntemortemDailyRecord::class, 'id_antemortem_daily_record'); }
}
