<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZeroToleranceInspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_master',
        'id_antemortem_daily_record',
        'milk',
        'fecal_matter',
        'rumen_content',
        'corrective_actions',
        'quantity',
    ];

    public function master() { return $this->belongsTo(MasterTable::class, 'id_master'); }
    public function antemortem_daily_record() { return $this->belongsTo(AntemortemDailyRecord::class, 'id_antemortem_daily_record'); }
}
